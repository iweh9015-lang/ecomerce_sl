{{-- resources/views/profile/partials/connected-accounts.blade.php --}}
<div class="mb-4">
    <p class="text-muted small">
        Hubungkan akun sosial Anda untuk proses login yang lebih cepat dan aman di masa mendatang.
    </p>

    <div class="d-flex flex-column gap-3">
        {{-- Google Account Card --}}
        <div class="p-3 rounded-4 border {{ $user->google_id ? 'border-primary-subtle bg-primary-subtle bg-opacity-10' : 'bg-white' }}" style="transition: all 0.3s ease;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    {{-- Google Icon Wrapper --}}
                    <div class="bg-white p-2 rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                    </div>

                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Google Account</h6>
                        @if($user->google_id)
                            <div class="d-flex align-items-center gap-1">
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-1" style="font-size: 0.7rem;">
                                    <i class="bi bi-patch-check-fill me-1"></i> Terhubung
                                </span>
                            </div>
                        @else
                            <small class="text-muted">Gunakan Google untuk akses instan</small>
                        @endif
                    </div>
                </div>

                <div>
                    @if($user->google_id)
                        <form action="{{ route('profile.connected-accounts.destroy', 'google') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light border text-danger rounded-pill px-3 fw-bold btn-sm"
                                onclick="return confirm('Apakah Anda yakin ingin memutuskan koneksi Google?')">
                                Putuskan
                            </button>
                        </form>
                    @else
                        <a href="{{ route('auth.google') }}" class="btn btn-dark rounded-pill px-3 fw-bold btn-sm">
                            <i class="bi bi-plus-lg me-1"></i> Hubungkan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Facebook Account Card (Contoh jika ingin ditambah nanti) --}}
        <div class="p-3 rounded-4 border bg-white opacity-50 shadow-none" style="border-style: dashed !important;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-light p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="bi bi-facebook text-secondary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-secondary">Facebook</h6>
                        <small class="text-muted">Segera hadir</small>
                    </div>
                </div>
                <button class="btn btn-light btn-sm disabled rounded-pill px-3" disabled>Hubungkan</button>
            </div>
        </div>
    </div>
</div>