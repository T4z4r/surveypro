@extends('layouts.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
            <svg class="text-white" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
        </div>
        <div>
            <h2 class="fw-bold display-5 text-dark mb-1">
                Results: {{ $survey->title }}
            </h2>
            <p class="text-muted mb-0">View survey responses and analytics</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('surveys.results.pdf', $survey) }}" target="_blank"
           class="btn btn-danger btn-sm">
            Export PDF
        </a>
        <a href="{{ route('surveys.results.csv', $survey) }}"
           class="btn btn-success btn-sm">
            Export CSV
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="py-5">
        <div class="container-fluid px-3 px-lg-5">
            <div class="bg-white overflow-hidden shadow rounded">
                <div class="p-3 bg-white border-bottom">
                    <div class="mb-4">
                        <p class="text-muted">Total Responses: {{ $survey->responses()->count() }}</p>
                        @if($survey->description)
                            <p class="text-dark mt-2">{{ $survey->description }}</p>
                        @endif
                    </div>

                    @if($survey->responses()->count() > 0)
                        @foreach($survey->questions as $question)
                            <div class="mb-4 p-3 border rounded">
                                <h3 class="fs-5 fw-medium text-dark mb-3">{{ $question->question }}</h3>

                                @if($question->type === 'text')
                                    <div>
                                        <h4 class="fw-medium text-dark">Text Responses:</h4>
                                        @if($results[$question->id]->isNotEmpty())
                                            @foreach($results[$question->id] as $answer)
                                                <div class="p-2 bg-light rounded mb-2">
                                                    {{ $answer ?: '(No answer)' }}
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted fst-italic">No responses yet.</p>
                                        @endif
                                    </div>

                                @else
                                    <div>
                                        <h4 class="fw-medium text-dark">Response Distribution:</h4>
                                        @if($results[$question->id]->isNotEmpty())
                                            @foreach($results[$question->id] as $optionData)
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="text-dark">{{ $optionData['option'] }}</span>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress me-2" style="width: 128px; height: 16px;">
                                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $survey->responses()->count() > 0 ? ($optionData['count'] / $survey->responses()->count()) * 100 : 0 }}%"></div>
                                                        </div>
                                                        <span class="fs-6 text-muted text-end" style="width: 48px;">{{ $optionData['count'] }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted fst-italic">No responses yet.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted fs-5">No responses have been submitted yet.</p>
                            <p class="text-secondary mt-2">Share the survey link to start collecting responses.</p>
                        </div>
                    @endif

                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('surveys.index') }}" class="btn btn-secondary">
                            Back to Surveys
                        </a>
                        <a href="{{ route('surveys.edit', $survey) }}" class="btn btn-primary">
                            Edit Survey
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
