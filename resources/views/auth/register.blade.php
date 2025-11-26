<x-guest-layout>
    @section('title', 'Register')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="h4 mb-4 text-center fw-bold">Create Your SurveyPro Account</h2>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-medium">Full Name</label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email Address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                Create Account
            </button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            <p class="text-muted mb-2">Already have an account?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                Sign In
            </a>
        </div>
    </form>
</x-guest-layout>
