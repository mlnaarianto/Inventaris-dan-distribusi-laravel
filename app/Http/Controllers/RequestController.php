<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductRequestDetail;
use App\Models\StockMutation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    /**
     * Pusat (request.view-all) melihat semua request, distributor hanya miliknya.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $isPusat = auth()->user()->can('request.view-all');

        $query = ProductRequest::with(['user', 'details'])->orderBy('created_at', 'desc');

        if (! $isPusat) {
            $query->where('user_id', auth()->id());
        }

        if ($status && in_array($status, ['pending', 'diproses', 'dikirim', 'selesai'])) {
            $query->where('status', $status);
        }

        $requests = $query->get();

        $view = $isPusat ? 'pusat.request.index' : 'distributor.request.index';

        return view($view, compact('requests', 'status'));
    }

    public function create()
    {
        $produk = Product::all();

        return view('distributor.request.create', compact('produk'));
    }

    public function store(Request $request)
    {
        if (! $request->has('product_id') || empty($request->product_id[0])) {
            return back()->with('error', 'Silakan pilih minimal 1 produk.');
        }

        $kodeRequest = 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $newRequest = ProductRequest::create([
            'user_id' => auth()->id(),
            'kode_request' => $kodeRequest,
            'tanggal_request' => now(),
            'status' => 'pending',
        ]);

        foreach ($request->product_id as $index => $productId) {
            $qty = $request->qty_diminta[$index];

            if ($productId && $qty > 0) {
                ProductRequestDetail::create([
                    'product_request_id' => $newRequest->id,
                    'product_id' => $productId,
                    'qty_diminta' => $qty,
                    'keterangan_sistem' => 'Menunggu Pengecekan Pusat',
                ]);
            }
        }

        return redirect()->route('request.index')->with('success', 'Permintaan barang berhasil dikirim ke Pusat!');
    }

    public function show(string $id)
    {
        $pengajuan = ProductRequest::with(['details.product', 'user'])->findOrFail($id);

        // Distributor hanya boleh melihat request miliknya sendiri
        if (! auth()->user()->can('request.view-all')) {
            abort_if($pengajuan->user_id !== auth()->id(), 403);
        }

        $view = auth()->user()->can('request.view-all')
            ? 'pusat.request.show'
            : 'distributor.request.show';

        return view($view, compact('pengajuan'));
    }

    /**
     * PUSAT: ubah status + potong stok (dulu: Pusat\RequestController@update)
     */
    public function updateStatus(Request $request, $id)
    {
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim',
        ]);

        $oldStatus = $pengajuan->status;
        $newStatus = $request->status;

        if ($oldStatus == 'pending' && ($newStatus == 'diproses' || $newStatus == 'dikirim')) {

            // Tahap A: cek stok semua barang (All or Nothing)
            foreach ($pengajuan->details as $detail) {
                $product = $detail->product;

                if ($product->stok_pusat < $detail->qty_diminta) {
                    return redirect()->back()->with('error', "Gagal memproses! Stok Gudang Pusat untuk barang [{$product->nama_barang}] tidak mencukupi. (Stok tersedia: {$product->stok_pusat}, Diminta: {$detail->qty_diminta})");
                }
            }

            // Tahap B: potong stok & catat mutasi keluar
            foreach ($pengajuan->details as $detail) {
                $product = $detail->product;

                $product->stok_pusat -= $detail->qty_diminta;
                $product->save();

                StockMutation::create([
                    'product_id'   => $product->id,
                    'jenis_mutasi' => 'keluar',
                    'qty'          => $detail->qty_diminta,
                    'tanggal'      => now(),
                    'keterangan'   => 'Pengiriman barang ke distributor untuk ' . $pengajuan->kode_request,
                ]);
            }
        }

        $pengajuan->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui dan stok pusat telah dikurangi!');
    }

    /**
     * DISTRIBUTOR: konfirmasi barang diterima (dulu: Distributor\RequestController@update)
     */
    public function terima(string $id)
    {
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        abort_if($pengajuan->user_id !== auth()->id(), 403);

        if ($pengajuan->status !== 'dikirim') {
            return back()->with('error', 'Gagal! Hanya pengiriman berstatus DIKIRIM yang bisa dikonfirmasi.');
        }

        foreach ($pengajuan->details as $detail) {
            $produk = $detail->product;

            $produk->stok_distributor += $detail->qty_diminta;
            $produk->save();

            StockMutation::create([
                'product_id' => $produk->id,
                'jenis_mutasi' => 'masuk',
                'qty' => $detail->qty_diminta,
                'tanggal' => now(),
                'keterangan' => 'Penerimaan barang dari ' . $pengajuan->kode_request,
            ]);
        }

        $pengajuan->update(['status' => 'selesai']);

        return back()->with('success', 'Konfirmasi berhasil! Barang telah diterima dan stok distributor telah bertambah.');
    }

    /**
     * PUSAT: cetak surat jalan PDF
     */
    public function cetak($id)
    {
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        $pdf = Pdf::loadView('pusat.request.cetak', compact('pengajuan'));

        return $pdf->stream('Surat-Jalan-' . $pengajuan->kode_request . '.pdf');
    }
}