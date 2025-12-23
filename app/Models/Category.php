<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /* =======================
     | SCOPES
     ======================= */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /* =======================
     | RELATIONS
     ======================= */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts()
    {
        return $this->hasMany(Product::class)
            ->where('is_active', true)
            ->where('stock', '>', 0);
    }
}
