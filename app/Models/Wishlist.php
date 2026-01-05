<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    // ==================== RELATIONSHIPS ====================

    public function wishlists()
    /*************  ✨ Windsurf Command ⭐  *************/
    /*
     * Get the product associated with the wishlist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*******  50e301d1-7225-43f3-9457-006552fc48b3  *******/
    {
        // Relasi User ke Product melalui tabel wishlists
        return $this->belongsToMany(Product::class, 'wishlists')
            ->withTimestamps(); // Agar created_at/updated_at di pivot terisi
    }

    // Helper untuk cek apakah user sudah wishlist produk tertentu
    public function hasInWishlist(Product $product)
    {
        return $this->wishlists()->where('product_id', $product->id)->exists();
    }
}
