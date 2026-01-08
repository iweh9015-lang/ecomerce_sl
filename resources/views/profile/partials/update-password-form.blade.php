{{-- resources/views/profile/partials/update-password-form.blade.php --}}

<p class="text-muted small mb-4">Pastikan akun Anda tetap aman dengan menggunakan kata sandi yang kuat dan unik.</p>

<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    {{-- Password Saat Ini --}}
    <div class="mb-3">
        <label for="current_password" class="form-label small fw-bold text-muted ps-1">Kata Sandi Saat Ini</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                <i class="bi bi-key text-muted"></i>
            </span>
            <input type="password" name="current_password" id="current_password"
                class="form-control bg-light border-start-0 rounded-end-pill @error('current_password', 'updatePassword') is-invalid @enderror"
                autocomplete="current-password" placeholder="••••••••">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <hr class="my-4 opacity-25">

    {{-- Password Baru --}}
    <div class="mb-3">
        <label for="password" class="form-label small fw-bold text-muted ps-1">Kata Sandi Baru</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                <i class="bi bi-shield-lock text-muted"></i>
            </span>
            <input type="password" name="password" id="password"
                class="form-control bg-light border-start-0 rounded-end-pill @error('password', 'updatePassword') is-invalid @enderror" 
                autocomplete="new-password" placeholder="Minimal 8 karakter">
            @error('password', 'updatePassword')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Konfirmasi Password --}}
    <div class="mb-4">
        <label for="password_confirmation" class="form-label small fw-bold text-muted ps-1">Konfirmasi Kata Sandi Baru</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                <i class="bi bi-shield-check text-muted"></i>
            </span>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="form-control bg-light border-start-0 rounded-end-pill @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                autocomplete="new-password" placeholder="Ulangi kata sandi baru">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-save me-2"></i>Perbarui Sandi
        </button>

        @if (session('status') === 'password-updated')
        <div class="text-success small fw-bold d-flex align-items-center animated fadeIn" id="status-message">
            <i class="bi bi-check-circle-fill me-1"></i> Berhasil disimpan
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('status-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
        @endif
    </div>
</form>

<style>
    /* Animasi sederhana untuk pesan sukses */
    .animated.fadeIn {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(-10px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>