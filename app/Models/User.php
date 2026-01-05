<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Storage;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * Kolom yang boleh diisi secara mass-assignment.
     * Ini mencegah vulnerability mass-assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'phone',
        'address',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi ke JSON/array.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * User memiliki satu keranjang aktif.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * User memiliki banyak item wishlist.
     */

    /**
     * User memiliki banyak pesanan.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi many-to-many ke products melalui wishlists.
     */
    public function wishlists()
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

    // ==================== HELPER METHODS ====================

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Cek apakah produk ada di wishlist user.
     */
    public function getAvatarUrlAttribute(): string
    {
        // Prioritas 1: Avatar yang di-upload (file fisik ada di server)
        // Kita harus cek Storage::exists() agar tidak broken image jika file-nya terhapus manual.
        if ($this->avatar && \Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/'.$this->avatar);
        }

        // Prioritas 2: Avatar dari Google (URL eksternal dimulai dengan http)
        // Biasanya ini terjadi saat user login via Socialite (Google Sign-In).
        if (str_starts_with($this->avatar ?? '', 'http')) {
            return $this->avatar;
        }

        // Prioritas 3: Gravatar (Layanan sedunia untuk avatar berdasarkan email)
        // Gravatar menggunakan MD5 hash dari email lowercase.
        // Jika user belum punya gravatar, tampilkan 'mp' (Mystery Person).
        // &s=200 artinya size gambar 200x200px.
        $hash = md5(strtolower(trim($this->email)));

        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    /**
     * Get initials from name for avatar fallback.
     * Contoh: "Agung Wahyudi" -> "AW"
     * Berguna jika kita ingin membuat UI avatar berupa inisial huruf teks.
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            // Ambil huruf pertama tiap kata dan kapitalkan
            $initials .= strtoupper(substr($word, 0, 1));
        }

        // Ambil maksimal 2 huruf pertama saja
        return substr($initials, 0, 2);
    }
}
