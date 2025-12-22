<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Cek apakah user adalah admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Mendapatkan URL avatar
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/'.$this->avatar);
        }

        if (str_starts_with($this->avatar ?? '', 'http')) {
            return $this->avatar;
        }

        $hash = md5(strtolower(trim($this->email)));

        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    // Mendapatkan inisial nama pengguna
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }

    // Relasi ke keranjang (1:1)
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // Relasi banyak ke banyak ke produk wishlist
    // app/Models/User.php

    // ...

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Helper untuk cek apakah user sudah wishlist produk tertentu
    public function hasInWishlist(Product $product)
    {
        return $this->wishlists()->where('product_id', $product->id)->exists();
    }

    // Relasi ke item keranjang (1:N)
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relasi ke produk (1:1) jika pengguna memiliki satu produk tertentu
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Metode untuk menghitung subtotal keranjang berdasarkan harga dan kuantitas
    public function getSubtotalAttribute()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->price * $item->quantity;  // Menambahkan harga produk * kuantitas
        }

        return $total;
    }
}
