{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Inventaris Produk')

@section('content')
<style>
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    
    .product-img-preview {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .badge-soft-success { background-color: #dcfce7; color: #15803d; }
    .badge-soft-secondary { background-color: #f1f5f9; color: #475569; }
    .badge-soft-danger { background-color: #fee2e2; color: #b91c1c; }
    .badge-soft-warning { background-color: #fef9c3; color: #a16207; }

    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        border: none;
    }

    .search-input-group {
        background: white;
        border-radius: 12px;
        padding: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 fw-bold text-dark mb-1">Daftar Produk</h2>
            <p class="text-muted small mb-0">Kelola stok, harga, dan visibilitas katalog Anda.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-2"></i> Tambah Produk Baru
        </a>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-3">
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group search-input-group border">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-0 shadow-none" 
                               placeholder="Cari berdasarkan nama atau SKU..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select border-light shadow-none py-2" style="border-radius: 10px;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button class="btn btn-dark w-100 rounded-3 py-2 fw-bold">Terapkan Filter</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light border w-auto rounded-3 py-2"><i class="bi bi-arrow-clockwise"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Info Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}" 
                                     class="product-img-preview me-3">
                                <div>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <small class="text-muted">ID: #{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark fw-medium">{{ $product->category->name }}</span>
                        </td>
                        <td>
                            <div class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </td>
                        <td>
                            @if($product->stock <= 5)
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold text-danger me-2">{{ $product->stock }}</span>
                                    <span class="badge badge-soft-danger px-2 py-1" style="font-size: 0.65rem">Low Stock</span>
                                </div>
                            @else
                                <span class="fw-semibold">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $product->is_active ? 'badge-soft-success' : 'badge-soft-secondary' }} rounded-pill px-3">
                                {{ $product->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="action-btn bg-info bg-opacity-10 text-info" title="Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="action-btn bg-warning bg-opacity-10 text-warning" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button class="action-btn bg-danger bg-opacity-10 text-danger" title="Hapus">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <img src="{{ asset('img/empty-box.png') }}" class="mb-3 opacity-20" width="80">
                            <p class="text-muted">Tidak ada produk yang ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="card-footer bg-white border-0 py-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection