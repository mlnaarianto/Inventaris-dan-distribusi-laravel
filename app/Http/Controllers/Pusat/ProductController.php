<?php

namespace App\Http\Controllers\Pusat;

use App\Http\Controllers\Controller;
use App\Models\Product; // Menggunakan Product sesuai nama model kamu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua varian produk (Katalog Master).
     */
    public function index()
    {
        // Mengambil semua data dari tabel products melalui model Product
        $produk = Product::all();
        return view('pusat.produk.index', compact('produk'));
    }

    /**
     * Menampilkan halaman form tambah produk baru.
     */
    public function create()
    {
        return view('pusat.produk.create');
    }

    /**
     * Menyimpan data produk baru dan memproses upload gambar fisik.
     */
    public function store(Request $request)
    {
        // 1. Validasi inputan form dari user
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'ukuran'      => 'required|string|max:100',
            'satuan'      => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok_pusat'  => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        // 2. Proses upload gambar jika ada file yang diunggah
        if ($request->hasFile('gambar')) {
            // Menyimpan file di folder: storage/app/public/produk
            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        // Set default stok distributor untuk produk baru sebesar 0
        $validated['stok_distributor'] = 0;

        // 3. Simpan data ke database melalui Model Product
        Product::create($validated);

        return redirect()->route('pusat.produk.index')
            ->with('success', 'Katalog produk baru berhasil ditambahkan ke sistem!');
    }

    /**
     * Menampilkan halaman form edit produk berdasarkan ID.
     */
    public function edit($id)
    {
        $produk = Product::findOrFail($id);
        return view('pusat.produk.edit', compact('produk'));
    }

    /**
     * Memperbarui data produk dan mengganti file gambar lama jika ada upload baru.
     */
    public function update(Request $request, $id)
    {
        $produk = Product::findOrFail($id);

        // 1. Validasi data pembaruan
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'ukuran'      => 'required|string|max:100',
            'satuan'      => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok_pusat'  => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Jika ada file gambar baru yang diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari folder storage jika sebelumnya sudah ada gambar
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            // Simpan gambar baru ke folder storage
            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        // 3. Jalankan perintah update data di database
        $produk->update($validated);

        return redirect()->route('pusat.produk.index')
            ->with('success', 'Informasi varian produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database beserta file gambar fisiknya dari storage.
     */
    public function destroy($id)
    {
        $produk = Product::findOrFail($id);

        // Hapus file gambar dari folder storage agar memori server tidak penuh
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        // Hapus baris data dari database
        $produk->delete();

        return redirect()->route('pusat.produk.index')
            ->with('success', 'Produk berhasil dihapus dari katalog master.');
    }
}
