<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua varian produk (Katalog Master).
     */
    public function index()
    {
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
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'ukuran'      => 'required|string|max:100',
            'satuan'      => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok_pusat'  => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        if ($request->hasFile('gambar')) {
            // Menyimpan file di folder: storage/app/public/produk
            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        // Set default stok distributor untuk produk baru sebesar 0
        $validated['stok_distributor'] = 0;

        Product::create($validated);

        return redirect()->route('produk.index')
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

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'ukuran'      => 'required|string|max:100',
            'satuan'      => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'stok_pusat'  => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika sebelumnya sudah ada
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $path = $request->file('gambar')->store('produk', 'public');
            $validated['gambar'] = $path;
        }

        $produk->update($validated);

        return redirect()->route('produk.index')
            ->with('success', 'Informasi varian produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database beserta file gambar fisiknya dari storage.
     */
    public function destroy($id)
    {
        $produk = Product::findOrFail($id);

        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus dari katalog master.');
    }
}