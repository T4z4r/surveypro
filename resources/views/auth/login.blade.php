<x-guest-layout>
    @section('title', 'Login')

    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="h4 mb-4 text-center fw-bold">Sign In to SurveyPro</h2>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email Address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label text-muted">
                Remember me
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="text-decoration-none small text-muted" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <button type="submit" class="btn btn-primary px-4">
                Sign In
            </button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p class="text-muted mb-2">Don't have an account?</p>
            <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
                Create Account
            </a>
        </div>
    </form>
</x-guest-layout>
