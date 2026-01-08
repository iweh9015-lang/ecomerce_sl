{{-- resources/views/profile/partials/update-avatar-form.blade.php --}}

<div class="mb-4 text-center text-md-start">
    <p class="text-muted small mb-4">
        Tampilkan wajah terbaik Anda. Format: **JPG, PNG, atau WebP** (Maks. 2MB).
    </p>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="d-flex flex-column flex-md-row align-items-center gap-4">
            {{-- Avatar Preview Container --}}
            <div class="position-relative group">
                <div class="avatar-wrapper rounded-circle p-1 border border-2 border-primary-subtle shadow-sm">
                    <img id="avatar-preview" 
                         class="rounded-circle object-fit-cover" 
                         style="width: 120px; height: 120px;"
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                         alt="{{ $user->name }}">
                </div>

                {{-- Delete Button (Hanya jika avatar ada) --}}
                @if($user->avatar)
                <button type="button"
                    onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()"
                    class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 shadow-sm border border-2 border-white d-flex align-items-center justify-content-center"
                    style="width: 30px; height: 30px;" title="Hapus foto">
                    <i class="bi bi-x-lg" style="font-size: 0.75rem;"></i>
                </button>
                @endif
            </div>

            {{-- Upload Input Area --}}
            <div class="flex-grow-1 w-100">
                <div class="upload-input-container">
                    <label for="avatar" class="form-label small fw-bold text-muted ps-1">Pilih File Baru</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(event)"
                        class="form-control rounded-pill border-2 @error('avatar') is-invalid @enderror">
                    @error('avatar')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mt-3 d-grid d-md-block">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" id="btn-save-avatar" style="display: none;">
                        <i class="bi bi-cloud-arrow-up me-2"></i>Simpan Foto Baru
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Hidden Form Delete Avatar --}}
<form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        const btnSave = document.getElementById('btn-save-avatar');
        
        if (file) {
            // Validasi ukuran file (2MB) sederhana di sisi client
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                preview.src = e.target.result;
                // Tambahkan animasi simpel
                preview.style.opacity = '0';
                setTimeout(() => {
                    preview.style.transition = 'opacity 0.5s ease';
                    preview.style.opacity = '1';
                }, 10);
            }
            reader.readAsDataURL(file);
            
            // Tampilkan tombol simpan hanya jika file dipilih
            btnSave.style.display = 'inline-block';
        }
    }
</script>

<style>
    .avatar-wrapper {
        background: #fff;
        transition: all 0.3s ease;
    }
    .avatar-wrapper:hover {
        border-color: #0d6efd !important;
        transform: scale(1.02);
    }
    #avatar:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
</style>