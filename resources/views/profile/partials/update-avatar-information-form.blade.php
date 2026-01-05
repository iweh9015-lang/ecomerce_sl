{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}

<p class="text-muted small">Perbarui informasi profil dan alamat email kamu.</p>

<form id="send-verification" method="post" action="">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    {{-- Nama --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        {{-- Email Verification Notice --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2">
            <p class="text-warning small mb-1">
                Email kamu belum diverifikasi.
                <button form="send-verification" class="btn btn-link p-0 align-baseline text-decoration-none">
                    Klik untuk kirim ulang email verifikasi.
                </button>
            </p>
            @if (session('status') === 'verification-link-sent')
            <p class="text-success small fw-bold">
                Link verifikasi baru telah dikirim ke email kamu.
            </p>
            @endif
        </div>
        @endif
    </div>

    {{-- Phone --}}
    <div class="mb-3">
        <label for="phone" class="form-label">Nomor Telepon</label>
        <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
        @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Format: 08xxxxxxxxxx atau +628xxxxxxxxxx</div>
    </div>

    {{-- Address --}}
    <div class="mb-3">
        <label for="address" class="form-label">Alamat Lengkap</label>
        <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror"
            placeholder="Alamat lengkap untuk pengiriman">{{ old('address', $user->address) }}</textarea>
        @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan Informasi</button>
</form>