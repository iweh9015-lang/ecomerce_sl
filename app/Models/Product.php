<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /* =======================
     | SCOPES
     ======================= */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeAvailable($query)
    {
        return $query->active()->inStock();
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /* =======================
     | RELATIONSHIPS
     ======================= */

    /**
     * Produk milik satu kategori
     * products.category_id → categories.id.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Gambar utama produk (opsional).
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)
            ->where('is_primary', true);
    }
}
