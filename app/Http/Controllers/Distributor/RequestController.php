<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductRequestDetail;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tangkap parameter 'status' dari URL
        $status = $request->query('status');

        // 2. Ambil data HANYA milik distributor yang sedang login
        $query = \App\Models\ProductRequest::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc');

        // 3. Jika ada filter status di URL, saring datanya
        if ($status && in_array($status, ['pending', 'diproses', 'dikirim', 'selesai'])) {
            $query->where('status', $status);
        }

        // 4. Eksekusi query
        $requests = $query->get();

        // Lempar data ke view beserta variabel status
        return view('distributor.request.index', compact('requests', 'status'));
    }

    public function create()
    {
        // Menampilkan semua produk agar distributor bisa memilih
        $produk = Product::all();
        return view('distributor.request.create', compact('produk'));
    }
    public function store(Request $request)
    {
        // 1. Pastikan ada produk yang dipilih di form
        if (!$request->has('product_id') || empty($request->product_id[0])) {
            return back()->with('error', 'Silakan pilih minimal 1 produk.');
        }

        // 2. Buat Header Request (Master Pesanan)
        $kodeRequest = 'REQ-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $newRequest = ProductRequest::create([
            'user_id' => auth()->id(), // PENTING: Menyimpan ID Distributor yang sedang login
            'kode_request' => $kodeRequest,
            'tanggal_request' => now(),
            'status' => 'pending'
        ]);

        // 3. Looping (Perulangan) untuk membaca form dinamis dan menyimpannya
        // Kita menggunakan array product_id[] dari form create.blade.php
        foreach ($request->product_id as $index => $productId) {

            // Ambil qty yang sejajar posisinya dengan produk yang dipilih
            $qty = $request->qty_diminta[$index];

            if ($productId && $qty > 0) {
                ProductRequestDetail::create([
                    'product_request_id' => $newRequest->id,
                    'product_id' => $productId,
                    'qty_diminta' => $qty,
                    'keterangan_sistem' => 'Menunggu Pengecekan Pusat'
                ]);
            }
        }

        return redirect()->route('distributor.request.index')->with('success', 'Permintaan barang berhasil dikirim ke Pusat!');
    }

    public function update(Request $request, string $id)
    {
        // Ambil data pengajuan beserta detail produknya
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        // Keamanan: Pastikan hanya barang berstatus 'dikirim' yang bisa dikonfirmasi
        if ($pengajuan->status !== 'dikirim') {
            return back()->with('error', 'Gagal! Hanya pengiriman berstatus DIKIRIM yang bisa dikonfirmasi.');
        }

        // Proses penambahan stok distributor dan pencatatan mutasi
        foreach ($pengajuan->details as $detail) {
            $produk = $detail->product;

            // 1. Tambah stok distributor
            $produk->stok_distributor += $detail->qty_diminta;
            $produk->save();

            // 2. Catat di kartu stok (Mutasi Masuk)
            \App\Models\StockMutation::create([
                'product_id' => $produk->id,
                'jenis_mutasi' => 'masuk',
                'qty' => $detail->qty_diminta,
                'tanggal' => now(),
                'keterangan' => 'Penerimaan barang dari ' . $pengajuan->kode_request
            ]);
        }

        // 3. Ubah status request menjadi selesai
        $pengajuan->update(['status' => 'selesai']);

        return back()->with('success', 'Konfirmasi berhasil! Barang telah diterima dan stok distributor telah bertambah.');
    }

    public function show(string $id)
    {
        // Mengambil data request beserta detail dan data produknya (Eager Loading)
        $pengajuan = ProductRequest::with('details.product')->findOrFail($id);

        return view('distributor.request.show', compact('pengajuan'));
    }
}
