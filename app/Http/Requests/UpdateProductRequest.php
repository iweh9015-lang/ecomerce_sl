<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan update produk.
     */
    public function authorize(): bool
    {
        // Sama seperti store: hanya admin
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Aturan validasi update produk.
     */
    public function rules(): array
    {
        return [
            // ======================
            // DATA PRODUK
            // ======================
            'category_id' => ['required', 'exists:categories,id'],

            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'price' => ['required', 'numeric', 'min:1000'],

            // discount_price harus < price
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],

            'stock' => ['required', 'integer', 'min:0'],
            'weight' => ['required', 'integer', 'min:1'],

            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],

            // ======================
            // GAMBAR BARU (OPTIONAL)
            // ======================
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // 2MB
            ],

            // ======================
            // HAPUS GAMBAR LAMA
            // ======================
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:product_images,id'],

            // ======================
            // SET PRIMARY IMAGE
            // ======================
            'primary_image' => ['nullable', 'integer', 'exists:product_images,id'],
        ];
    }

    /**
     * Normalisasi data sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
