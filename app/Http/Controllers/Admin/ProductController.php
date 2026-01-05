<?php

// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk dengan fitur pagination dan filtering.
     */
    public function index(Request $request): View
    {
        $products = Product::query()
        // Eager Loading: Meload relasi kategori & gambar utama sekaligus.
        // Tanpa 'with', Laravel akan mengeksekusi 1 query tambahan untuk SETIAP baris produk (N+1 Problem).
            ->with(['category', 'primaryImage'])

        // Filter: Pencarian nama produk
            ->when($request->search, function ($query, $search) {
                $query->search($search); // Menggunakan Scope 'search' di Model Product
            })
        // Filter: Berdasarkan Kategori
            ->when($request->category, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()           // Urut dari yang terbaru
            ->paginate(15)       // Batasi 15 item per halaman
            ->withQueryString(); // Memastikan parameter URL (?search=xx) tetap ada saat pindah halaman

        // Ambil data kategori untuk dropdown filter di view
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create(): View
    {
        // Ambil kategori untuk dropdown.
        // HANYA kategori yang aktif yang boleh dipilih.
        $categories = Category::active()->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke database.
     * Menggunakan DB Transaction untuk integritas data (Product + Images).
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        try {
            // === DB TRANSACTION START ===
            // Kita membungkus operasi ini dalam transaksi.
            // Mengapa? Karena kita melakukan DUA aksi penulisan database:
            // 1. Create Product
            // 2. Create Product Images
            // Jika step 2 gagal (misal upload error), step 1 harus DIBATALKAN (Rollback) agar tidak ada data sampah.
            DB::beginTransaction();

            // 1. Simpan data produk
            // $request->validated() hanya mengambil data yang lolos validasi di FormRequest.
            // Method create() memanfaatkan fitur Mass Assignment Laravel.
            $product = Product::create($request->validated());

            // 2. Upload gambar (jika ada)
            // Kita pisahkan logika upload ke helper method agar kode store() tetap bersih.
            if ($request->hasFile('images')) {
                $this->uploadImages($request->file('images'), $product);
            }

            // === DB TRANSACTION COMMIT ===
            // Jika sampai sini tidak ada error, simpan semua perubahan secara permanen.
            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            // === DB TRANSACTION ROLLBACK ===
            // Jika terjadi error APAPUN di block try, batalkan semua query yang sudah dijalankan.
            DB::rollBack();

            // Kembalikan user ke form sebelumnya dengan pesan error dan input mereka.
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan produk: '.$e->getMessage());
        }
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Product $product): View
    {
        // Load semua relasi yang dibutuhkan untuk halaman detail.
        $product->load(['category', 'images', 'orderItems']);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product): View
    {
        $categories = Category::active()->orderBy('name')->get();
        // Load gambar yang sudah ada agar bisa ditampilkan/dihapus di form edit.
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui data produk.
     * Juga menggunakan Transaction karena melibatkan update produk + upload/delete gambar.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // 1. Update data dasar produk
            $product->update($request->validated());

            // 2. Upload gambar BARU (jika user menambah gambar)
            if ($request->hasFile('images')) {
                $this->uploadImages($request->file('images'), $product);
            }

            // 3. Hapus gambar LAMA (yang dicentang user untuk dihapus)
            if ($request->has('delete_images')) {
                $this->deleteImages($request->delete_images);
            }

            // 4. Set gambar Utama (Primary Image)
            // Jika user memilih gambar tertentu jadi thumbnail baru.
            if ($request->has('primary_image')) {
                $this->setPrimaryImage($product, $request->primary_image);
            }

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Gagal update: '.$e->getMessage());
        }
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            // Loop dan hapus semua file gambar fisik dari server.
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Hapus record produk dari database.
            // Relasi lain (seperti cart_items atau order_items) mungkin perlu dicek
            // atau gunakan SoftDeletes jika ingin data aman. Di sini kita Hard Delete.
            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Produk dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: '.$e->getMessage());
        }
    }

    // --- Helper Methods ---
    // Method protected agar tidak bisa diakses via URL/Route, hanya internal class ini.

    protected function uploadImages(array $files, Product $product): void
    {
        // Cek apakah produk ini baru pertama kali punya gambar?
        // Jika ya, gambar pertama yang diupload otomatis jadi Primary.
        $isFirst = $product->images()->count() === 0;

        foreach ($files as $index => $file) {
            // Generate nama unik: product-{id}-{timestamp}-{index}.ext
            $filename = 'product-'.$product->id.'-'.time().'-'.$index.'.'.$file->extension();

            // Simpan fisik file
            $path = $file->storeAs('products', $filename, 'public');

            // Simpan info ke database table product_images
            $product->images()->create([
                'image_path' => $path,
                // Jika ini gambar pertama, set as primary
                'is_primary' => $isFirst && $index === 0,
                'sort_order' => $product->images()->count() + $index,
            ]);
        }
    }

    protected function deleteImages(array $imageIds): void
    {
        // Ambil data gambar berdasarkan ID yang dikirim
        $images = ProductImage::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            // Hapus file fisik
            Storage::disk('public')->delete($image->image_path);
            // Hapus record DB
            $image->delete();
        }
    }

    protected function setPrimaryImage(Product $product, int $imageId): void
    {
        // Reset semua gambar produk ini jadi non-primary
        $product->images()->update(['is_primary' => false]);

        // Set gambar yang dipilih jadi primary
        $product->images()->where('id', $imageId)->update(['is_primary' => true]);
    }
}
