{{-- resources/views/profile/partials/update-avatar-form.blade.php --}}

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Upload foto profil kamu. Format yang didukung: JPG, PNG, WebP. Maksimal 2MB.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center gap-6">
            {{-- Avatar Preview --}}
            <div class="shrink-0">
                <div class="relative">
                    <img id="avatar-preview" class="h-24 w-24 rounded-full object-cover border-4 border-gray-200" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $user->name }}">

                    {{-- Delete button (jika ada avatar) --}}
                    @if($user->avatar)
                    <button type="button" onclick="document.getElementById('delete-avatar-form').submit()" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition" title="Hapus foto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    @endif
                </div>
            </div>

            {{-- Upload Input --}}
            <div class="flex-1">
                <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/webp" onchange="previewAvatar(event)" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0 file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                              cursor-pointer">
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Simpan Foto') }}</x-primary-button>
        </div>
    </form>

    {{-- Hidden form untuk hapus avatar --}}
    <form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    {{-- Preview Script --}}
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
</section>
