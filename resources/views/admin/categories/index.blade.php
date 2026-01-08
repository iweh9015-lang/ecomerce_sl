@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@push('styles')
<style>
    /* ===== ADMIN SOFT UI THEME ===== */
    .card-admin {
        border: none;
        border-radius: 1rem;
        background: #ffffff;
    }

    /* Table Styling */
    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #64748b;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table tbody td {
        padding: 1rem;
        color: #334155;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Soft Badges */
    .badge-soft-info { background: #e0f2fe; color: #0369a1; }
    .badge-soft-success { background: #dcfce7; color: #15803d; }
    .badge-soft-secondary { background: #f1f5f9; color: #475569; }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 1.25rem;
    }
    
    .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 1.5rem;
    }

    .form-control, .form-select {
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        border: 1px solid #e2e8f0;
    }

    .form-control:focus {
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        border-color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    
    {{-- HEADER SECTION --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-black text-dark mb-1">Manajemen Kategori</h4>
            <p class="text-muted small mb-0">Kelola dan klasifikasikan produk toko Anda.</p>
        </div>
        <button class="btn btn-primary px-4 rounded-pill shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="ti ti-plus me-1"></i> Tambah Kategori
        </button>
    </div>

    {{-- ALERT MESSAGES --}}
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
        <i class="ti ti-circle-check fs-5 me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card card-admin shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Detail Kategori</th>
                        <th class="text-center">Total Produk</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" class="rounded-3 me-3 object-fit-cover shadow-sm"
                                    width="48" height="48">
                                @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center me-3 text-muted shadow-sm"
                                    style="width:48px;height:48px">
                                    <i class="ti ti-photo fs-5"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ $category->name }}</div>
                                    <code class="text-primary small" style="font-size: 0.75rem;">{{ $category->slug }}</code>
                                </div>
                            </div>
                        </td>

                        <td class="text-center">
                            <span class="badge badge-soft-info px-3 py-2 rounded-pill fw-bold">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>

                        <td class="text-center">
                            @if($category->is_active)
                            <span class="badge badge-soft-success px-3 py-2 rounded-pill fw-bold">
                                <i class="ti ti-circle-check me-1"></i> Aktif
                            </span>
                            @else
                            <span class="badge badge-soft-secondary px-3 py-2 rounded-pill fw-bold">
                                <i class="ti ti-circle-x me-1"></i> Nonaktif
                            </span>
                            @endif
                        </td>

                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-action btn-outline-warning border-0" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $category->id }}" title="Edit">
                                    <i class="ti ti-edit fs-5"></i>
                                </button>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action btn-outline-danger border-0" title="Hapus">
                                        <i class="ti ti-trash fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT (In-Loop) --}}
                    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <form class="modal-content shadow-lg" action="{{ route('admin.categories.update', $category) }}" 
                                method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="fw-black mb-0">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted">NAMA KATEGORI</label>
                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small text-muted">FOTO KATEGORI</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between bg-light p-3 rounded-3">
                                        <label class="form-check-label fw-bold text-dark mb-0">Status Aktif</label>
                                        <input class="form-check-input ms-0" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light border-0">
                                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="py-4">
                                <i class="ti ti-folder-off display-4 text-light mb-3 d-block"></i>
                                <h6 class="text-muted">Belum ada kategori ditemukan.</h6>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content shadow-lg" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="fw-black mb-0">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">NAMA KATEGORI</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Gadget & Elektronik" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small text-muted">FOTO KATEGORI</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between bg-light p-3 rounded-3">
                    <label class="form-check-label fw-bold text-dark mb-0">Aktifkan Langsung</label>
                    <input class="form-check-input ms-0" type="checkbox" name="is_active" value="1" checked>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection