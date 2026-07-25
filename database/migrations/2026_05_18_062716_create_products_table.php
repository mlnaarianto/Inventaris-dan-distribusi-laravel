<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

        $table->id();
        $table->string('nama_barang');
        $table->string('ukuran');
        $table->string('satuan');
        $table->integer('stok_pusat')->default(0);
        $table->integer('stok_distributor')->default(0);

        // KOLOM BARU UNTUK HARGA & GAMBAR
        $table->decimal('harga', 12, 2)->default(0);
        $table->string('gambar')->nullable();

        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
