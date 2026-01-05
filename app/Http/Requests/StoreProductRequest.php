<?php

// app/Http/Requests/StoreProductRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        // Hanya user dengan role 'admin' yang boleh menambah produk.
        // auth()->check() memastikan user sudah login.
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi untuk data yang dikirim.
     */
    public function rules(): array
    {
        return [
            // category_id harus ada di tabel categories kolom id
            'category_id' => ['required', 'exists:categories,id'],

            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            // Harga minimal 1000 rupiah
            'price' => ['required', 'numeric', 'min:1000'],

            // Harga diskon (opsional), tapi jika diisi:
            // 1. Harus numeric
            // 2. Minimal 0
            // 3. Harus KURANG DARI ('lt' = less than) harga asli (price)
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],

            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['required', 'integer', 'min:1'], // Berat minimal 1 gram

            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],

            // Validasi Array Gambar
            // 'images' harus berupa array
            // Maksimal 10 file sekaligus
            'images' => ['nullable', 'array', 'max:10'],

            // Validasi TIAP item di dalam array images
            // 'images.*' artinya "setiap file di dalam array images"
            'images.*' => [
                'image',              // Harus berupa file gambar
                'mimes:jpg,png,webp', // Ekstensi yang diperbolehkan
                'max:2048',           // Maksimal 2MB per file (2048 KB)
            ],
        ];
    }

    /**
     * Persiapkan data sebelum validasi dijalankan.
     * Berguna untuk normalisasi data.
     */
    protected function prepareForValidation(): void
    {
        // Checkbox di HTML kadang tidak mengirim value jika tidak dicentang (atau kirim string "on").
        // Kita paksa konversi jadi boolean true/false agar database menerima nilai yang benar (1/0).
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
