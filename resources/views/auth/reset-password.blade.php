<x-guest-layout>
    @section('title', 'Reset Password')

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <h2 class="h4 mb-4 text-center fw-bold">Set New Password</h2>

        <p class="text-muted mb-4 text-center">
            Enter your new password below.
        </p>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email Address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">New Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-medium">Confirm New Password</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                Reset Password
            </button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none text-muted small">
                ← Back to Sign In
            </a>
        </div>
    </form>
</x-guest-layout>
