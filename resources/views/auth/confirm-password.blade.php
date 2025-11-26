<x-guest-layout>
    @section('title', 'Confirm Password')

    <div class="text-center mb-4">
        <div class="mb-3">
            <svg class="text-primary mx-auto" width="48" height="48" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm3 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
            </svg>
        </div>
        <h2 class="h4 mb-3 fw-bold">Confirm Your Password</h2>
        <p class="text-muted">
            For your security, please confirm your password before continuing.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                Confirm Password
            </button>
        </div>
    </form>
</x-guest-layout>
