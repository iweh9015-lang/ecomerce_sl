{{-- resources/views/profile/partials/update-avatar-form.blade.php --}}

<p class="text-muted small">
    Upload foto profil kamu. Format yang didukung: JPG, PNG, WebP. Maksimal 2MB.
</p>

<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="d-flex align-items-center gap-4">
        {{-- Avatar Preview --}}
        <div class="position-relative">
            <img id="avatar-preview" class="rounded-circle object-fit-cover border" style="width: 100px; height: 100px;"
                src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                alt="{{ $user->name }}">

            @if($user->avatar)
            <button type="button"
                onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()"
                class="btn btn-danger btn-sm rounded-circle position-absolute top-0 start-100 translate-middle p-1"
                style="width: 24px; height: 24px; line-height: 1;" title="Hapus foto">
                &times;
            </button>
            @endif
        </div>

        {{-- Upload Input --}}
        <div class="flex-grow-1">
            <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(event)"
                class="form-control @error('avatar') is-invalid @enderror">
            @error('avatar')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Simpan Foto</button>
    </div>
</form>

{{-- Hidden Form Delete Avatar --}}
<form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>