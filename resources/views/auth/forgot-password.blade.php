<x-guest-layout>
    @section('title', 'Forgot Password')

    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <h2 class="h4 mb-4 text-center fw-bold">Reset Your Password</h2>

        <p class="text-muted mb-4 text-center">
            Enter your email address and we'll send you a link to reset your password.
        </p>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email Address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                Send Reset Link
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
