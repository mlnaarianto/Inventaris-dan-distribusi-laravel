<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Pastikan model Product di-import

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'nama_barang' => 'Pocari Sweat Botol',
                'ukuran'      => '330ml',
                'satuan'      => 'Dus',
                'harga'       => 120000,
                'stok_pusat'  => 500,
                'stok_distributor' => 0,
                'gambar'      => null, // Sengaja null agar pakai inisial huruf di view
            ],
            [
                'nama_barang' => 'Pocari Sweat Botol',
                'ukuran'      => '500ml',
                'satuan'      => 'Dus',
                'harga'       => 165000,
                'stok_pusat'  => 450,
                'stok_distributor' => 0,
                'gambar'      => null,
            ],
            [
                'nama_barang' => 'Pocari Sweat Botol',
                'ukuran'      => '900ml',
                'satuan'      => 'Dus',
                'harga'       => 145000,
                'stok_pusat'  => 300,
                'stok_distributor' => 0,
                'gambar'      => null,
            ],
            [
                'nama_barang' => 'Pocari Sweat Botol',
                'ukuran'      => '2 Liter',
                'satuan'      => 'Dus',
                'harga'       => 125000,
                'stok_pusat'  => 200,
                'stok_distributor' => 0,
                'gambar'      => null,
            ],
            [
                'nama_barang' => 'Pocari Sweat Kaleng',
                'ukuran'      => '330ml',
                'satuan'      => 'Dus',
                'harga'       => 135000,
                'stok_pusat'  => 600,
                'stok_distributor' => 0,
                'gambar'      => null,
            ],
            [
                'nama_barang' => 'Oronamin C',
                'ukuran'      => '120ml', // Ukuran khusus Oronamin
                'satuan'      => 'Dus',
                'harga'       => 250000,
                'stok_pusat'  => 400,
                'stok_distributor' => 0,
                'gambar'      => null,
            ],
            [
                'nama_barang' => 'Ion Water Botol',
                'ukuran'      => '500ml',
                'satuan'      => 'Dus',
                'harga'       => 155000,
                'stok_pusat'  => 350,
                'stok_distributor' => 0,
                'gambar'      => null,
            ],
        ];

        // Looping untuk memasukkan data ke database
        foreach ($products as $item) {
            Product::create($item);
        }
    }
}
