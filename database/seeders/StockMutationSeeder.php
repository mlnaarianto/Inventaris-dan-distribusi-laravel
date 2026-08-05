<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockMutation;
use Carbon\Carbon;

class StockMutationSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh membuat data riwayat mutasi/permintaan beberapa bulan ke belakang
        // Agar AI punya "bahan" untuk melihat tren naik-turunnya permintaan barang
        
        $types = ['masuk', 'keluar'];
        
        for ($i = 1; $i <= 50; $i++) {
            StockMutation::create([
                'product_id' => rand(1, 7), // Mengacu ke ID produk 1 sampai 7
                'jenis_mutasi' => 'keluar', // Misal barang keluar untuk distributor
                'qty' => rand(10, 50),     // Jumlah barang yang diminta/dikirim
                'tanggal' => Carbon::now()->subDays(rand(1, 90)), // Tanggal acak 90 hari ke belakang
                'keterangan' => 'Pengiriman rutin ke distributor',
            ]);
        }
    }
}