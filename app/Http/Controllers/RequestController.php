<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductRequestDetail;
use App\Models\StockMutation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    private const STATUSES = ['pending', 'diproses', 'dikirim', 'selesai'];

    /**
     * Yang punya request.view-all (pusat, super-admin) melihat semua order.
     * Selain itu hanya order miliknya sendiri.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = ProductRequest::with(['user', 'details'])->orderBy('created_at', 'desc');

        // Tanpa request.view-all, hanya tampilkan milik sendiri
        if (! auth()->user()->can('request.view-all')) {
            $query->where('user_id', auth()->id());
        }

        if ($status && in_array($status, self::STATUSES)) {
            $query->where('status', $status);
        } else {
            $status = null;
        }

        $requests = $query->get();

        return view('request.index', compact('requests', 'status'));
    }

    public function create()
    {
        $produk = Product::all();

        return view('request.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|array|min:1',
            'product_id.*'  => 'required|exists:products,id',
            'qty_diminta'   => 'required|array',
            'qty_diminta.*' => 'required|integer|min:1',
        ], [
            'product_id.required' => 'Silakan pilih minimal 1 produk.',
        ]);

        DB::transaction(function () use ($request) {
            $newRequest = ProductRequest::create([
                'user_id'         => auth()->id(),
                'kode_request'    => 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
                'tanggal_request' => now(),
                'status'          => 'pending',
            ]);

            foreach ($request->product_id as $index => $productId) {
                ProductRequestDetail::create([
                    'product_request_id' => $newRequest->id,
                    'product_id'         => $productId,
                    'qty_diminta'        => $request->qty_diminta[$index],
                    'keterangan_sistem'  => 'Menunggu Pengecekan Pusat',
                ]);
            }
        });

        return redirect()->route('request.index')->with('success', 'Permintaan barang berhasil dikirim ke Pusat!');
    }

    public function show(string $id)
    {
        $pengajuan = ProductRequest::with(['details.product', 'user'])->findOrFail($id);

        $this->authorizeOwnerOrViewAll($pengajuan);

        return view('request.show', compact('pengajuan'));
    }

    /**
     * Pusat: ubah status. Stok pusat dipotong saat order pertama kali keluar dari "pending".
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim',
        ]);

        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        $oldStatus = $pengajuan->status;
        $newStatus = $request->status;

        if ($oldStatus === 'selesai') {
            return back()->with('error', 'Pesanan sudah selesai dan tidak bisa diubah lagi.');
        }

        // Status hanya boleh maju, supaya stok tidak terpotong dua kali
        $urutan = array_flip(self::STATUSES);
        if ($urutan[$newStatus] <= $urutan[$oldStatus]) {
            return back()->with('error', 'Status hanya bisa dimajukan, tidak bisa diturunkan atau diulang.');
        }

        if ($oldStatus === 'pending') {
            // Tahap A: cek stok semua barang (All or Nothing)
            foreach ($pengajuan->details as $detail) {
                $product = $detail->product;

                if (! $product || $product->stok_pusat < $detail->qty_diminta) {
                    $nama = $product?->nama_barang ?? 'Produk Dihapus';
                    $stok = $product?->stok_pusat ?? 0;

                    return back()->with('error', "Gagal memproses! Stok Gudang Pusat untuk barang [{$nama}] tidak mencukupi. (Stok tersedia: {$stok}, Diminta: {$detail->qty_diminta})");
                }
            }

            // Tahap B: potong stok & catat mutasi keluar
            DB::transaction(function () use ($pengajuan, $newStatus) {
                foreach ($pengajuan->details as $detail) {
                    $product = $detail->product;
                    $product->decrement('stok_pusat', $detail->qty_diminta);

                    StockMutation::create([
                        'product_id'   => $product->id,
                        'jenis_mutasi' => 'keluar',
                        'qty'          => $detail->qty_diminta,
                        'tanggal'      => now(),
                        'keterangan'   => 'Pengiriman barang ke distributor untuk ' . $pengajuan->kode_request,
                    ]);
                }

                $pengajuan->update(['status' => $newStatus]);
            });

            return back()->with('success', 'Status pesanan diperbarui dan stok pusat telah dikurangi!');
        }

        $pengajuan->update(['status' => $newStatus]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Distributor (atau yang punya request.view-all): konfirmasi barang diterima,
     * stok distributor bertambah.
     */
    public function terima(string $id)
    {
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        $this->authorizeOwnerOrViewAll($pengajuan);

        if ($pengajuan->status !== 'dikirim') {
            return back()->with('error', 'Gagal! Hanya pengiriman berstatus DIKIRIM yang bisa dikonfirmasi.');
        }

        DB::transaction(function () use ($pengajuan) {
            foreach ($pengajuan->details as $detail) {
                $produk = $detail->product;
                $produk->increment('stok_distributor', $detail->qty_diminta);

                StockMutation::create([
                    'product_id'   => $produk->id,
                    'jenis_mutasi' => 'masuk',
                    'qty'          => $detail->qty_diminta,
                    'tanggal'      => now(),
                    'keterangan'   => 'Penerimaan barang dari ' . $pengajuan->kode_request,
                ]);
            }

            $pengajuan->update(['status' => 'selesai']);
        });

        return back()->with('success', 'Konfirmasi berhasil! Barang telah diterima dan stok distributor telah bertambah.');
    }

    /**
     * Pusat: cetak surat jalan PDF.
     */
    public function cetak($id)
    {
        $pengajuan = ProductRequest::with(['details.product', 'user'])->findOrFail($id);

        $this->authorizeOwnerOrViewAll($pengajuan);

        $pdf = Pdf::loadView('request.cetak', compact('pengajuan'));

        $nama = 'Surat-Jalan-' . $pengajuan->kode_request . '.pdf';

        return request()->boolean('unduh') ? $pdf->download($nama) : $pdf->stream($nama);
    }

    /**
     * Pemilik order atau yang punya request.view-all (pusat, super-admin) boleh lanjut.
     */
    private function authorizeOwnerOrViewAll(ProductRequest $pengajuan): void
    {
        abort_unless(
            auth()->user()->can('request.view-all') || $pengajuan->user_id === auth()->id(),
            403
        );
    }
}