<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SurveyPro') }} - Create & Analyze Surveys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <header class="bg-white shadow-sm py-3">
        <div class="container">
            @if (Route::has('login'))
                <nav class="d-flex justify-content-end gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 mb-5">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-dark mb-4">Welcome to SurveyPro</h1>
                    <p class="lead text-muted mb-5">Create, manage, and analyze surveys with ease. Gather insights from your audience with our powerful survey platform.</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-12 col-md-6">
                        <div class="card border-primary h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <svg class="text-white" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark mb-0">Create Surveys</h5>
                                </div>
                                <p class="card-text text-muted mb-4">Build comprehensive surveys with multiple question types including text, radio buttons, and checkboxes.</p>
                                <a href="{{ route('surveys.create') }}" class="btn btn-primary d-flex align-items-center">
                                    Create Survey
                                    <svg class="ms-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card border-success h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <svg class="text-white" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark mb-0">View Results</h5>
                                </div>
                                <p class="card-text text-muted mb-4">Analyze survey responses with detailed statistics, charts, and export options for PDF and CSV.</p>
                                <a href="{{ route('surveys.index') }}" class="btn btn-success d-flex align-items-center">
                                    View Surveys
                                    <svg class="ms-2" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-info bg-light mb-5">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark mb-4">Key Features</h5>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <ul class="list-unstyled">
                                    <li class="d-flex align-items-center mb-3">
                                        <svg class="text-success me-3 flex-shrink-0" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Multiple question types</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-3">
                                        <svg class="text-success me-3 flex-shrink-0" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Real-time response tracking</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-md-6">
                                <ul class="list-unstyled">
                                    <li class="d-flex align-items-center mb-3">
                                        <svg class="text-success me-3 flex-shrink-0" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Export to PDF & CSV</span>
                                    </li>
                                    <li class="d-flex align-items-center mb-3">
                                        <svg class="text-success me-3 flex-shrink-0" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>User-friendly interface</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-muted mb-4">Ready to get started? Create your first survey or explore existing ones.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        @auth
                            <a href="{{ route('surveys.create') }}" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center">
                                <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Your First Survey
                            </a>
                            <a href="{{ route('surveys.index') }}" class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center">
                                Browse Surveys
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center">
                                Get Started - Sign Up
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="bg-primary p-4 rounded-end rounded-bottom d-flex align-items-center justify-content-center" style="min-height: 400px;">
                    <div class="text-center text-white">
                        <div class="mb-4">
                            <svg class="text-white" width="80" height="80" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <h2 class="h3 mb-3">SurveyPro</h2>
                        <p class="mb-0">Powerful Survey Platform</p>
                        <p class="small mt-2 opacity-75">Create • Analyze • Share</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
