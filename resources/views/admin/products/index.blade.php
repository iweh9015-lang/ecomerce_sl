{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="row">
    <div class="col-lg-8">
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold">Daftar Kategori</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg"></i> Tambah Baru
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Nama Kategori</th>
                                <th class="text-center">Produk</th>
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
                                                <img src="{{ Storage::url($category->image) }}" class="rounded me-2" width="40" height="40">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $category->name }}</div>
                                                <small class="text-muted">{{ $category->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark">{{ $category->products_count }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($category->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-warning me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $category->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- EDIT MODAL per Loop Item --}}
                                <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form class="modal-content" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Kategori</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gambar (Opsional)</label>
                                                    <input type="file" name="image" class="form-control">
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                                           {{ $category->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label">Aktif</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

{{-- CREATE MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="Misal: Elektronik">
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Cover</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                    <label class="form-check-label">Langsung Aktifkan</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection