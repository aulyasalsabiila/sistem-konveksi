<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bahan')->unique();
            $table->string('nama_bahan');
            $table->enum('kategori', ['Kain', 'Aksesoris', 'Sablon', 'Kemasan']);
            $table->decimal('stok', 10, 2);
            $table->string('satuan'); // meter, kg, pcs, cone, dll
            $table->decimal('minimum_stok', 10, 2);
            $table->decimal('harga_satuan', 12, 2);
            $table->string('supplier')->nullable();
            $table->string('kontak_supplier')->nullable();
            $table->date('last_restock')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};