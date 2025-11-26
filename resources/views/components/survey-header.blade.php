<div class="d-flex align-items-center gap-3">
    <div class="bg-{{ $bgColor ?? 'success' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
        <svg class="text-white" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"></path>
        </svg>
    </div>
    <div>
        <h2 class="fw-bold display-5 text-dark mb-1">
            {{ $title }}
        </h2>
        <p class="text-muted mb-0">{{ $description }}</p>
    </div>
</div>