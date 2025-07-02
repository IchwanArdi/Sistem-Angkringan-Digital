<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_order',
        'total_harga',
        'status',
        'catatan',
        'user_id'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    public function user() {
    return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y H:i') : '';
    }
    
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'selesai' => 'badge-success',
            'dibatalkan' => 'badge-danger'
        ];
        
        return $badges[$this->status] ?? 'badge-secondary';
    }
    
    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Menunggu',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        
        return $texts[$this->status] ?? 'Unknown';
    }
    
    public function getTotalItemsAttribute()
    {
        return $this->orderItems->sum('jumlah');
    }

    public static function generateKodeOrder()
    {
        $date = Carbon::now()->format('Ymd');
        $count = self::whereDate('created_at', Carbon::today())->count() + 1;
        return 'ANG-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
    
    public static function getNextOrderNumber()
    {
        return self::generateKodeOrder();
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
    }
    
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }
    
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeCancelled($query)
    {
        return $query->where('status', 'dibatalkan');
    }
    
    public function scopeWithRevenue($query)
    {
        return $query->where('status', 'selesai');
    }
    
    public function canBeEdited()
    {
        return $this->status === 'pending';
    }
    
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending']);
    }
    
    public function canBeCompleted()
    {
        return $this->status === 'pending';
    }
    
    public function canBeDeleted()
    {
        return in_array($this->status, ['pending', 'dibatalkan']);
    }
}