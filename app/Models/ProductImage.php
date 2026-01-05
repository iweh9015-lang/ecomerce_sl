<?php

// app/Models/ProductImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // ==================== RELATIONSHIPS ====================

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ==================== ACCESSORS ====================

    /**
     * URL gambar lengkap.
     */
    public function getImageUrlAttribute(): string
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/'.$this->image_path);
    }

    /**
     * URL thumbnail (jika menggunakan image processing).
     */
    public function getThumbnailUrlAttribute(): string
    {
        // Jika punya thumbnail terpisah
        $thumbnailPath = str_replace('.', '_thumb.', $this->image_path);

        if (Storage::disk('public')->exists($thumbnailPath)) {
            return asset('storage/'.$thumbnailPath);
        }

        return $this->image_url;
    }

    // ==================== BOOT ====================

    protected static function boot()
    {
        parent::boot();

        // Hapus file saat record dihapus
        static::deleting(function ($image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }

    // ==================== HELPER METHODS ====================

    /**
     * Set gambar ini sebagai primary.
     */
    public function makePrimary(): void
    {
        // Unset primary lainnya
        $this->product->images()
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        // Set ini sebagai primary
        $this->update(['is_primary' => true]);
    }
}
