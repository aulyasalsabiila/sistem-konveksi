<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanans')->onDelete('cascade');
            $table->enum('stage', [
                'Persiapan',
                'Potong',
                'Jahit',
                'Finishing',
                'QC',
                'Packing'
            ])->default('Persiapan');
            $table->enum('status', ['Pending', 'Progress', 'Done'])->default('Pending');
            $table->string('pic')->nullable(); // Person In Charge
            $table->integer('progress_percentage')->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->date('estimasi_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};