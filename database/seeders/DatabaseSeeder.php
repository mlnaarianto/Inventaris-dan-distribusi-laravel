<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil semua seeder secara berurutan
        $this->call([
            UserSeeder::class,    // Membuat akun Pusat & Distributor
            ProductSeeder::class, // Mengisi katalog barang Pocari
            StockMutationSeeder::class, // Mengisi data mutasi/permintaan barang
        ]);
    }
}
