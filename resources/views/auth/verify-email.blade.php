<x-guest-layout>
    @section('title', 'Verify Email')

    <div class="text-center">
        <div class="mb-4">
            <svg class="text-warning mx-auto mb-3" width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
        </div>

        <h2 class="h4 mb-4 fw-bold">Verify Your Email Address</h2>

        <p class="text-muted mb-4">
            Thanks for signing up! We've sent a verification link to your email address.
            Please click the link in the email to activate your account.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mb-4">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <p class="text-muted small mb-4">
            Didn't receive the email? Check your spam folder or click below to resend.
        </p>

        <div class="d-grid gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
