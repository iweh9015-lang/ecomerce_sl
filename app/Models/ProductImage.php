<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    /** @use HasFactory<\Database\Factories\ProductImageFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'sort_order',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->image_path)) {
            // Absolute URL
            if (str_starts_with($this->image_path, 'http')) {
                return $this->image_path;
            }

            // Public path (public/ folder)
            if (file_exists(public_path($this->image_path))) {
                return asset($this->image_path);
            }

            // Storage (storage/app/public)
            if (file_exists(storage_path('app/public/'.ltrim($this->image_path, '/')))) {
                return asset('storage/'.ltrim($this->image_path, '/'));
            }
        }

        return asset('images/no-image.png');
    }
}
