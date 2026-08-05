<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StockMutation;
use Illuminate\Support\Facades\File;

class ExportStockData extends Command
{
    protected $signature = 'export:stock-csv';
    protected $description = 'Ekspor data mutasi stok ke format CSV untuk AI Kaggle';

    public function handle()
    {
        // Mengambil data mutasi beserta relasi produknya
        $mutations = StockMutation::with('product')->get();

        // Tentukan path file CSV hasil ekspor
        $fileName = 'stock_mutations_data.csv';
        $filePath = public_path($fileName);

        $file = fopen($filePath, 'w');

        // Buat Header Kolom CSV
        fputcsv($file, ['id', 'product_id', 'nama_barang', 'jenis_mutasi', 'qty', 'tanggal', 'keterangan']);

        // Masukkan data baris per baris
        foreach ($mutations as $row) {
            fputcsv($file, [
                $row->id,
                $row->product_id,
                $row->product->nama_barang ?? 'N/A',
                $row->jenis_mutasi,
                $row->qty,
                $row->tanggal,
                $row->keterangan,
            ]);
        }

        fclose($file);

        $this->info("Berhasil! File CSV tersimpan di: " . $filePath);
    }
}