<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'kategori',
        'stok',
        'deskripsi',
        'tersedia',
        'user_id'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'tersedia' => 'boolean'
    ];

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}