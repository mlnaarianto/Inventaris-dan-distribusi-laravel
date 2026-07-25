<?php

namespace App\Http\Controllers\Pusat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductRequest;
use App\Models\StockMutation;
use Barryvdh\DomPDF\Facade\Pdf;

class RequestController extends Controller
{
    /**
     * Menampilkan semua daftar permintaan barang yang masuk dari distributor.
     */
    public function index(Request $request)
    {
        // 1. Tangkap parameter 'status' dari URL
        $status = $request->query('status');

        // 2. Mulai query pemanggilan data dengan relasi user (distributor)
        $query = \App\Models\ProductRequest::with('user')->orderBy('created_at', 'desc');

        // 3. Jika ada filter status di URL, saring datanya
        if ($status && in_array($status, ['pending', 'diproses', 'dikirim', 'selesai'])) {
            $query->where('status', $status);
        }

        // 4. Eksekusi query
        $requests = $query->get();

        // Lempar data request dan status saat ini ke view
        return view('pusat.request.index', compact('requests', 'status'));
    }

    /**
     * Menampilkan detail item permintaan untuk dilakukan validasi stok fisik.
     */
    public function show(string $id)
    {
        // Eager loading detail beserta relasi produknya agar performa query ringan
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);
        return view('pusat.request.show', compact('pengajuan'));
    }

    /**
     * Memperbarui status permintaan sekaligus memproses kalkulasi dan mutasi stok.
     */

    public function update(Request $request, $id)
{
    // Ambil data pengajuan beserta detail barang dan relasi produknya
    $pengajuan = \App\Models\ProductRequest::with('details.product')->findOrFail($id);

    // 1. Validasi: Pusat HANYA boleh mengubah ke pending, diproses, atau dikirim (Selesai dihapus)
    $request->validate([
        'status' => 'required|in:pending,diproses,dikirim'
    ]);

    $oldStatus = $pengajuan->status;
    $newStatus = $request->status;

    // 2. LOGIKA KEBUTUHAN STOK: Jika status berubah dari 'pending' maju ke 'diproses' atau 'dikirim'
    if ($oldStatus == 'pending' && ($newStatus == 'diproses' || $newStatus == 'dikirim')) {

        // Tahap A: Cek ketersediaan stok pusat untuk SEMUA barang di dalam list (All or Nothing)
        foreach ($pengajuan->details as $detail) {
            $product = $detail->product;

            if ($product->stok_pusat < $detail->qty_diminta) {
                // Jika ada 1 saja barang yang stoknya kurang, batalkan seluruh proses
                return redirect()->back()->with('error', "Gagal memproses! Stok Gudang Pusat untuk barang [{$product->nama_barang}] tidak mencukupi. (Stok tersedia: {$product->stok_pusat}, Diminta: {$detail->qty_diminta})");
            }
        }

        // Tahap B: Jika semua barang lolos pengecekan stok, lakukan pemotongan stok & catat mutasi keluar
        foreach ($pengajuan->details as $detail) {
            $product = $detail->product;

            // Kurangi stok gudang pusat
            $product->stok_pusat -= $detail->qty_diminta;
            $product->save();

            // Catat ke kartu stok gudang pusat sebagai 'Keluar'
            \App\Models\StockMutation::create([
                'product_id'   => $product->id,
                'jenis_mutasi' => 'keluar',
                'qty'          => $detail->qty_diminta,
                'tanggal'      => now(),
                'keterangan'   => 'Pengiriman barang ke distributor untuk ' . $pengajuan->kode_request
            ]);
        }
    }

    // 3. Update status pesanan di tabel master request
    $pengajuan->update([
        'status' => $newStatus
    ]);

    return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui dan stok pusat telah dikurangi!');
}

    /**
     * Mengonversi data transaksi menjadi dokumen Surat Jalan format PDF.
     */
    public function cetak($id)
    {
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        // Memanggil file view cetak dan menyuntikkan data pengajuan ke dalamnya
        $pdf = Pdf::loadView('pusat.request.cetak', compact('pengajuan'));

        // Stream langsung ke browser (membuka tab baru untuk print/download)
        return $pdf->stream('Surat-Jalan-' . $pengajuan->kode_request . '.pdf');
    }
}
