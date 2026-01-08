@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header dengan Breadcrumb sederhana --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active fw-bold">Pengaturan Profil</li>
                </ol>
            </nav>

            <div class="row g-4">
                {{-- Sidebar Info Singkat --}}
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4 sticky-top" style="top: 100px;">
                        <div class="mb-3 position-relative d-inline-block mx-auto">
                            <img id="avatarPreviewSide" 
                                 src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) . '?' . time() : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D6EFD&color=fff' }}" 
                                 class="rounded-circle border border-4 border-white shadow object-fit-cover" 
                                 width="120" height="120" alt="Avatar">
                        </div>
                        <h5 class="fw-bold mb-0 text-truncate">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small mb-3">{{ auth()->user()->email }}</p>
                        <hr class="opacity-50">
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="bi bi-bag me-1"></i> Riwayat Pesanan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kolom Utama --}}
                <div class="col-md-8">
                    {{-- Form Informasi Utama --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0"><i class="bi bi-person-circle me-2 text-primary"></i>Informasi Profil</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                <div class="mb-4 d-flex align-items-center gap-4 bg-light p-3 rounded-4 border border-dashed">
                                    <div class="position-relative">
                                        <img id="avatarPreview" 
                                             src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) . '?' . time() : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=0D6EFD&color=fff' }}" 
                                             class="rounded-circle border border-3 border-white shadow-sm object-fit-cover" 
                                             width="80" height="80" alt="Avatar">
                                        <label for="avatarInput" class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 shadow-sm p-0 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; cursor: pointer;">
                                            <i class="bi bi-camera-fill" style="font-size: 0.75rem;"></i>
                                        </label>
                                        <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Foto Profil</h6>
                                        <p class="text-muted small mb-0">Rekomendasi ukuran 512x512px. Maks 2MB.</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-uppercase tracking-wider">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control rounded-3 bg-light border-0 py-2 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-uppercase tracking-wider">Alamat Email</label>
                                        <input type="email" name="email" class="form-control rounded-3 bg-light border-0 py-2 @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm hover-up">
                                        Simpan Perubahan
                                    </button>
                                    @if (session('status') === 'profile-updated')
                                        <span class="ms-3 text-success small fw-medium animate__animated animate__fadeIn"><i class="bi bi-check-all"></i> Berhasil disimpan!</span>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Form Ganti Password --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0"><i class="bi bi-shield-lock me-2 text-warning"></i>Keamanan Akun</h5>
                        </div>
                        <div class="card-body p-4">
                            <form method="post" action="{{ route('password.update') }}">
                                @csrf @method('put')
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold text-uppercase">Password Saat Ini</label>
                                        <input type="password" name="current_password" class="form-control rounded-3 bg-light border-0 py-2 @error('current_password', 'updatePassword') is-invalid @enderror">
                                        @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase">Password Baru</label>
                                        <input type="password" name="password" class="form-control rounded-3 bg-light border-0 py-2 @error('password', 'updatePassword') is-invalid @enderror">
                                        @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-uppercase">Ulangi Password Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control rounded-3 bg-light border-0 py-2">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-dark px-4 rounded-pill fw-bold hover-up">Ganti Password</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Danger Zone --}}
                    <div class="card border-0 shadow-sm rounded-4 border-top border-danger border-4 bg-danger bg-opacity-10">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-bold text-danger mb-1">Hapus Akun</h5>
                                <p class="text-muted small mb-0">Data Anda akan dihapus secara permanen.</p>
                            </div>
                            <button class="btn btn-outline-danger px-4 rounded-pill fw-bold btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                Hapus Akun
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tetap Sama --}}
<div class="modal fade" id="confirmDeleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 rounded-4 shadow-lg">
            @csrf
            @method('delete')
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-3">Tolong masukkan password Anda untuk menghapus akun **permanen**.</p>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control border-danger rounded-3" id="delPass" placeholder="Password">
                    <label for="delPass">Masukkan Password Konfirmasi</label>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">Ya, Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-control:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important; border-color: #0d6efd !important; }
    .hover-up { transition: all 0.3s ease; }
    .hover-up:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .tracking-wider { letter-spacing: 1px; font-size: 0.7rem; }
    .border-dashed { border-style: dashed !important; border-color: #dee2e6 !important; }
</style>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
                document.getElementById('avatarPreviewSide').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection