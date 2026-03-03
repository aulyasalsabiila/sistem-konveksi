<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'stage',
        'status',
        'pic',
        'progress_percentage',
        'tanggal_mulai',
        'tanggal_selesai',
        'estimasi_selesai',
        'catatan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'estimasi_selesai' => 'date'
    ];

    // Relationship
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function pemakaianBahan()
    {
        return $this->hasMany(PemakaianBahan::class);
    }

    // Scope untuk produksi aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'Progress');
    }
}