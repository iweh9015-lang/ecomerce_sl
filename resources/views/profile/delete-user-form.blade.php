{{-- resources/views/profile/partials/delete-user-form.blade.php --}}

<p class="text-muted small">
    Setelah akun dihapus, semua data dan resource akan hilang permanen. Silahkan unduh data penting sebelum menghapus.
</p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    Hapus Akun
</button>

<!-- Modal -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
            @csrf
            @method('delete')

            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Apakah kamu yakin ingin menghapus akun ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">
                    Setelah akun dihapus, semua data akan hilang permanen. Masukkan password untuk konfirmasi.
                </p>

                <div class="mb-3">
                    <label for="password" class="form-label visually-hidden">Password</label>
                    <input type="password"
                           name="password"
                           id="password"
                           class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                           placeholder="Masukkan password kamu"
                           required>
                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    <script type="module">
        // Auto open modal if validation fails
        // Pastikan script ini berjalan setelah bootstrap dimuat (vite)
        const myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        myModal.show();
    </script>
@endif