<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
    ];

    protected $with = ['items.product'];

    // ==================== RELATIONSHIPS ====================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Hitung subtotal semua item di keranjang.
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->total_price;
        });
    }

    /**
     * Hitung total berat semua item di keranjang.
     */
    public function getTotalWeightAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->total_weight;
        });
    }
}
