<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan')->unique();
            $table->string('nama_pemesan');
            $table->string('kontak');
            $table->text('alamat')->nullable();
            $table->string('jenis_produk');
            $table->integer('jumlah');
            $table->text('ukuran'); // JSON string: S(20), M(30), dll
            $table->string('warna');
            $table->text('spesifikasi')->nullable();
            $table->date('tanggal_pesan');
            $table->date('deadline');
            $table->decimal('harga_per_pcs', 12, 2);
            $table->decimal('total_harga', 15, 2);
            $table->decimal('dp', 15, 2)->default(0);
            $table->decimal('sisa_pembayaran', 15, 2);
            $table->enum('status', [
                'Pending',
                'Dikonfirmasi',
                'Proses Produksi',
                'QC',
                'Siap Kirim',
                'Selesai'
            ])->default('Pending');
            $table->text('keterangan')->nullable();
            $table->string('foto_desain')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};