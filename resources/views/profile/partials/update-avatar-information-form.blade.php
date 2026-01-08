{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}

<p class="text-muted small mb-4">Pastikan data diri Anda akurat untuk memudahkan proses pengiriman pesanan.</p>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="row">
        {{-- Nama Lengkap --}}
        <div class="col-md-12 mb-3">
            <label for="name" class="form-label small fw-bold text-muted">Nama Lengkap</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                    <i class="bi bi-person text-muted"></i>
                </span>
                <input type="text" name="name" id="name" 
                    class="form-control bg-light border-start-0 rounded-end-pill @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="col-md-12 mb-3">
            <label for="email" class="form-label small fw-bold text-muted">Alamat Email</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                    <i class="bi bi-envelope text-muted"></i>
                </span>
                <input type="email" name="email" id="email" 
                    class="form-control bg-light border-start-0 rounded-end-pill @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email Verification Notice --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2 p-2 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3">
                <p class="text-dark small mb-0 px-2 d-flex align-items-center">
                    <i class="bi bi-exclamation-circle-fill text-warning me-2"></i>
                    Email belum diverifikasi.
                    <button form="send-verification" class="btn btn-link p-0 ms-2 small fw-bold text-decoration-none" style="font-size: 0.8rem;">
                        Kirim ulang link?
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                <p class="text-success small fw-bold mb-0 px-2 mt-1 animated fadeIn">
                    <i class="bi bi-check2-all me-1"></i> Link baru telah dikirim!
                </p>
                @endif
            </div>
            @else 
            <div class="mt-1 ps-2">
                <small class="text-success" style="font-size: 0.75rem;">
                    <i class="bi bi-patch-check-fill me-1"></i> Email terverifikasi
                </small>
            </div>
            @endif
        </div>

        {{-- Nomor Telepon --}}
        <div class="col-md-12 mb-3">
            <label for="phone" class="form-label small fw-bold text-muted">Nomor Telepon</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                    <i class="bi bi-phone text-muted"></i>
                </span>
                <input type="tel" name="phone" id="phone" 
                    class="form-control bg-light border-start-0 rounded-end-pill @error('phone') is-invalid @enderror"
                    value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
                @error('phone')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-text ps-2 text-muted" style="font-size: 0.7rem;">Gunakan format angka saja (cth: 0812345678)</div>
        </div>

        {{-- Alamat Lengkap --}}
        <div class="col-md-12 mb-4">
            <label for="address" class="form-label small fw-bold text-muted">Alamat Pengiriman</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0 rounded-3 px-3 align-items-start pt-2">
                    <i class="bi bi-geo-alt text-muted"></i>
                </span>
                <textarea name="address" id="address" rows="3" 
                    class="form-control bg-light border-start-0 rounded-3 @error('address') is-invalid @enderror"
                    placeholder="Contoh: Jl. Merdeka No. 123, Jakarta Selatan">{{ old('address', $user->address) }}</textarea>
                @error('address')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="d-grid d-md-block">
        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
            Simpan Perubahan
        </button>
    </div>
</form>