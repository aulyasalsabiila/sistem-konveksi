<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_bahan',
        'nama_bahan',
        'kategori',
        'stok',
        'satuan',
        'minimum_stok',
        'harga_satuan',
        'supplier',
        'kontak_supplier',
        'last_restock'
    ];

    protected $casts = [
        'stok' => 'decimal:2',
        'minimum_stok' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'last_restock' => 'date'
    ];

    // Auto-generate kode bahan
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($bahan) {
            if (empty($bahan->kode_bahan)) {
                $lastBahan = self::latest('id')->first();
                $number = $lastBahan ? intval(substr($lastBahan->kode_bahan, -3)) + 1 : 1;
                $bahan->kode_bahan = 'BB-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // Accessor untuk status stok
    public function getStatusStokAttribute()
    {
        if ($this->stok >= $this->minimum_stok) {
            return 'Aman';
        } elseif ($this->stok > 0) {
            return 'Menipis';
        } else {
            return 'Habis';
        }
    }

    // Scope untuk stok menipis
    public function scopeStokMenurun($query)
    {
        return $query->whereColumn('stok', '<', 'minimum_stok');
    }
}