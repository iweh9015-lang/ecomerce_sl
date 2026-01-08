{{-- resources/views/profile/partials/delete-user-form.blade.php --}}

<div class="d-flex align-items-start gap-3">
    <div class="flex-grow-1">
        <p class="text-muted small mb-3">
            Menghapus akun akan membatalkan semua akses Anda secara permanen. Tindakan ini tidak dapat dibatalkan dan semua data pesanan serta riwayat Anda akan dihapus dari sistem kami.
        </p>
        
        <button type="button" class="btn btn-outline-danger fw-bold rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
            <i class="bi bi-trash3 me-2"></i> Ajukan Penghapusan Akun
        </button>
    </div>
</div>

<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
            @csrf
            @method('delete')

            <div class="modal-body p-4 text-center">
                {{-- Icon Peringatan --}}
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                    <i class="bi bi-exclamation-octagon-fill fs-1"></i>
                </div>

                <h4 class="fw-bold text-dark mb-2">Konfirmasi Hapus Akun</h4>
                <p class="text-muted mb-4 small">
                    Untuk alasan keamanan, silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun ini secara permanen.
                </p>

                <div class="text-start">
                    <label for="password" class="form-label small fw-bold text-muted ps-1">Kata Sandi Konfirmasi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill px-3">
                            <i class="bi bi-shield-lock text-muted"></i>
                        </span>
                        <input type="password" name="password" id="password"
                            class="form-control bg-light border-start-0 rounded-end-pill py-2 @error('password', 'userDeletion') is-invalid @enderror"
                            placeholder="Ketik password Anda..." required>
                    </div>
                    @error('password', 'userDeletion')
                        <div class="text-danger small mt-2 ps-2">
                            <i class="bi bi-info-circle me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="modal-footer border-0 p-4 pt-0 gap-2">
                <button type="button" class="btn btn-light rounded-pill px-4 flex-fill fw-bold" data-bs-dismiss="modal">Batalkan</button>
                <button type="submit" class="btn btn-danger rounded-pill px-4 flex-fill fw-bold">Ya, Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        myModal.show();
    });
</script>
@endif