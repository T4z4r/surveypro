<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h2 class="fw-bold display-5 text-dark mb-1">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-muted mb-0">Welcome back! Here's an overview of your surveys.</p>
            </div>
            <a href="{{ route('surveys.create') }}" class="btn btn-primary btn-lg d-flex align-items-center">
                <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create New Survey
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container-fluid px-4">
            <!-- Stats Cards -->
            <div class="row g-4 mb-5">
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-primary">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold text-dark mb-1">{{ $totalSurveys }}</h3>
                                <p class="card-text text-muted mb-0">Total Surveys</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-success">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold text-dark mb-1">{{ $totalResponses }}</h3>
                                <p class="card-text text-muted mb-0">Total Responses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-info">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold text-dark mb-1">{{ $activeSurveys }}</h3>
                                <p class="card-text text-muted mb-0">Active Surveys</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Surveys -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold text-dark mb-0">Recent Surveys</h5>
                                <a href="{{ route('surveys.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($recentSurveys->count() > 0)
                                <div class="row g-3">
                                    @foreach($recentSurveys as $survey)
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="card h-100 border">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <h6 class="card-title fw-bold text-dark mb-1">{{ Str::limit($survey->title, 30) }}</h6>
                                                        <span class="badge {{ $survey->status === 'active' ? 'bg-success' : 'bg-secondary' }} small">
                                                            {{ ucfirst($survey->status) }}
                                                        </span>
                                                    </div>
                                                    @if($survey->description)
                                                        <p class="card-text text-muted small mb-2">{{ Str::limit($survey->description, 60) }}</p>
                                                    @endif
                                                    <div class="d-flex align-items-center text-muted small mb-3">
                                                        <svg class="me-1" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        {{ $survey->created_at->format('M j, Y') }}
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('surveys.take', $survey) }}" class="btn btn-primary btn-sm flex-fill">Take Survey</a>
                                                        <a href="{{ route('surveys.results', $survey) }}" class="btn btn-outline-primary btn-sm flex-fill">Results</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                        <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-primary">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h6 class="text-muted mb-2">No surveys yet</h6>
                                    <a href="{{ route('surveys.create') }}" class="btn btn-primary btn-sm">Create Your First Survey</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
