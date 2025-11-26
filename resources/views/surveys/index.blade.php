@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div class="flex-grow-1">
        {!! view('components.survey-header', [
            'title' => __('Surveys'),
            'description' => 'Create and manage your surveys',
            'bgColor' => 'primary',
            'iconPath' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
        ]) !!}
    </div>
    <div class="ms-3">
        <a href="{{ route('surveys.create') }}" class="btn btn-primary btn-lg d-flex align-items-center">
            <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create New Survey
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="py-4">
    <div class="container-fluid px-4">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($surveys->count() > 0)
                <!-- Survey Grid -->
                <div class="row g-4 mb-4">
                    @foreach($surveys as $survey)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title fw-bold text-dark mb-2">{{ $survey->title }}</h5>
                                            @if($survey->description)
                                                <p class="card-text text-muted small">{{ Str::limit($survey->description, 100) }}</p>
                                            @endif
                                        </div>
                                        <span class="badge {{ $survey->status === 'active' ? 'bg-success' : 'bg-secondary' }} ms-2">
                                            {{ ucfirst($survey->status) }}
                                        </span>
                                    </div>

                                    <div class="d-flex align-items-center text-muted small mb-3">
                                        <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $survey->created_at->format('M j, Y') }}
                                    </div>

                                    <div class="mt-auto">
                                        <div class="d-flex gap-2 mb-3">
                                            <a href="{{ route('surveys.take', $survey) }}" class="btn btn-primary btn-sm d-flex align-items-center">
                                                <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                                Take Survey
                                            </a>
                                            <a href="{{ route('surveys.results', $survey) }}" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                                <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                Results
                                            </a>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('surveys.edit', $survey) }}" class="text-muted" title="Edit">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('surveys.duplicate', $survey) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="text-warning border-0 bg-transparent" onclick="return confirm('Duplicate this survey?')" title="Duplicate">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                            <form method="POST" action="{{ route('surveys.destroy', $survey) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger border-0 bg-transparent" onclick="return confirm('Are you sure you want to delete this survey?')" title="Delete">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $surveys->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="text-primary">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h4 class="card-title fw-bold text-dark mb-3">No surveys yet</h4>
                        <p class="card-text text-muted mb-4">Get started by creating your first survey. It's quick and easy to set up questions and start collecting responses.</p>
                        <a href="{{ route('surveys.create') }}" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center mx-auto" style="width: fit-content;">
                            <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Your First Survey
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
