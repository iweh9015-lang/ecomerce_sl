{{-- resources/views/partials/flash-messages.blade.php --}}

<div class="flash-container px-3 mt-3">
    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show rounded-4 py-3" role="alert">
        <div class="d-flex align-items-center">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0;">
                <i class="bi bi-check-lg"></i>
            </div>
            <div class="text-dark fw-medium">{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show rounded-4 py-3" role="alert">
        <div class="d-flex align-items-center">
            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0;">
                <i class="bi bi-exclamation-circle"></i>
            </div>
            <div class="text-dark fw-medium">{{ session('error') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Info Message --}}
    @if(session('info'))
    <div class="alert alert-info border-0 shadow-sm alert-dismissible fade show rounded-4 py-3" role="alert">
        <div class="d-flex align-items-center">
            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0;">
                <i class="bi bi-info-lg"></i>
            </div>
            <div class="text-dark fw-medium">{{ session('info') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show rounded-4 py-3" role="alert">
        <div class="d-flex align-items-start">
            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3 mt-1" style="width: 32px; height: 32px; flex-shrink: 0;">
                <i class="bi bi-x-lg"></i>
            </div>
            <div>
                <strong class="text-dark d-block mb-1">Terjadi kesalahan:</strong>
                <ul class="mb-0 small text-muted ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<style>
    .flash-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .alert {
        transition: all 0.3s ease;
    }
    .alert:hover {
        transform: translateY(-2px);
    }
    .btn-close:focus {
        box-shadow: none;
    }
</style>