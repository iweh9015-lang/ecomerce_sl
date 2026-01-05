{{-- resources/views/profile/partials/update-password-form.blade.php --}}

<p class="text-muted small">Pastikan akun kamu aman dengan menggunakan password yang panjang dan acak.</p>

<form method="post" action="">
    @csrf
    @method('put')

    {{-- Current Password --}}
    <div class="mb-3">
        <label for="current_password" class="form-label">Password Saat Ini</label>
        <input type="password" name="current_password" id="current_password"
            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
            autocomplete="current-password">
        @error('current_password', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- New Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">Password Baru</label>
        <input type="password" name="password" id="password"
            class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
        @error('password', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Confirm Password --}}
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
            autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">Update Password</button>

        @if (session('status') === 'password-updated')
        <span class="text-success small fade-out">Saved.</span>
        <script>
            setTimeout(() => document.querySelector('.fade-out').style.display = 'none', 2000);
        </script>
        @endif
    </div>
</form>