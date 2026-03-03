<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'description',
        'changes',
        'ip_address'
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method untuk icon
    public function getIconAttribute()
    {
        return match($this->action) {
            'create' => 'fa-plus-circle text-green-600',
            'update' => 'fa-edit text-blue-600',
            'delete' => 'fa-trash text-red-600',
            'login' => 'fa-sign-in-alt text-purple-600',
            'logout' => 'fa-sign-out-alt text-gray-600',
            default => 'fa-info-circle text-gray-600'
        };
    }

    // Helper method untuk warna badge
    public function getBadgeColorAttribute()
    {
        return match($this->action) {
            'create' => 'bg-green-100 text-green-800',
            'update' => 'bg-blue-100 text-blue-800',
            'delete' => 'bg-red-100 text-red-800',
            'login' => 'bg-purple-100 text-purple-800',
            'logout' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}