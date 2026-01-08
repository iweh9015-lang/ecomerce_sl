<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'weight',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // ==================== BOOT ====================

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);

                // Pastikan slug unik
                $count = static::where('slug', 'like', $product->slug.'%')->count();
                if ($count > 0) {
                    $product->slug .= '-'.($count + 1);
                }
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Produk termasuk dalam satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Produk memiliki banyak gambar.
     */
    // Pastikan ini ada di App\Models\Product.php
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getImageUrlAttribute()
    {
        if ($this->primaryImage) {
            return asset('storage/'.$this->primaryImage->image_path);
        }

        return asset('images/no-image.png'); // Sediakan gambar default
    }

    /**
     * Item pesanan yang mengandung produk ini.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ==================== ACCESSORS ====================

    /**
     * Harga yang ditampilkan (diskon atau normal).
     */
    public function getDisplayPriceAttribute(): float
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Format harga untuk tampilan.
     * Contoh: Rp 1.500.000.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp '.number_format($this->display_price, 0, ',', '.');
    }

    /**
     * Format harga asli (sebelum diskon).
     */
    public function getFormattedOriginalPriceAttribute(): string
    {
        return 'Rp '.number_format($this->price, 0, ',', '.');
    }

    /**
     * Persentase diskon.
     */
    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->has_discount) {
            return 0;
        }

        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    /**
     * Cek apakah produk memiliki diskon.
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null
        && $this->discount_price < $this->price;
    }

    /**
     * URL gambar utama atau placeholder.
     */

    /**
     * Cek apakah produk tersedia (aktif dan ada stok).
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->is_active && $this->stock > 0;
    }

    // ==================== SCOPES ====================

    /**
     * Filter produk aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Filter produk unggulan.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Filter produk yang tersedia (ada stok).
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Filter berdasarkan kategori (menggunakan slug).
     */
    public function scopeByCategory($query, string $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    /**
     * Pencarian produk.
     */
    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        });
    }

    /**
     * Filter berdasarkan range harga.
     */
    public function scopePriceRange($query, float $min, float $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }
}
