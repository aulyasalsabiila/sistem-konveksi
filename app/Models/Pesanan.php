<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pesanan',
        'nama_pemesan',
        'kontak',
        'alamat',
        'jenis_produk',
        'jumlah',
        'ukuran',
        'warna',
        'spesifikasi',
        'tanggal_pesan',
        'deadline',
        'harga_per_pcs',
        'total_harga',
        'dp',
        'sisa_pembayaran',
        'status',
        'keterangan',
        'foto_desain'
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',
        'deadline' => 'date',
        'harga_per_pcs' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'dp' => 'decimal:2',
        'sisa_pembayaran' => 'decimal:2'
    ];

    // Relationship
    public function produksi()
    {
        return $this->hasOne(Produksi::class);
    }

    // Auto-generate kode pesanan
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pesanan) {
            if (empty($pesanan->kode_pesanan)) {
                $year = date('Y');
                $lastPesanan = self::whereYear('created_at', $year)->latest('id')->first();
                $number = $lastPesanan ? intval(substr($lastPesanan->kode_pesanan, -3)) + 1 : 1;
                $pesanan->kode_pesanan = 'PO-' . $year . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // Scope untuk filter
    public function scopeByStatus($query, $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeByDateRange($query, $start, $end)
    {
        if ($start && $end) {
            return $query->whereBetween('tanggal_pesan', [$start, $end]);
        }
        return $query;
    }
}