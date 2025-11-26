<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SurveyPro') }} - {{ $title ?? 'Authentication' }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none">
                            <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <svg width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                            </div>
                            <h1 class="h3 text-dark fw-bold mb-1">SurveyPro</h1>
                            <p class="text-muted small">Powerful Survey Platform</p>
                        </a>
                    </div>

                    <div class="card shadow">
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="/" class="text-decoration-none text-muted small">
                            ← Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
