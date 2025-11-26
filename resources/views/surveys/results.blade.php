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
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <p class="text-gray-600">Total Responses: {{ $survey->responses()->count() }}</p>
                        @if($survey->description)
                            <p class="text-gray-700 mt-2">{{ $survey->description }}</p>
                        @endif
                    </div>

                    @if($survey->responses()->count() > 0)
                        @foreach($survey->questions as $question)
                            <div class="mb-8 p-6 border border-gray-200 rounded">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $question->question }}</h3>

                                @if($question->type === 'text')
                                    <div class="space-y-2">
                                        <h4 class="font-medium text-gray-700">Text Responses:</h4>
                                        @if($results[$question->id]->isNotEmpty())
                                            @foreach($results[$question->id] as $answer)
                                                <div class="p-3 bg-gray-50 rounded">
                                                    {{ $answer ?: '(No answer)' }}
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-gray-500 italic">No responses yet.</p>
                                        @endif
                                    </div>

                                @else
                                    <div class="space-y-3">
                                        <h4 class="font-medium text-gray-700">Response Distribution:</h4>
                                        @if($results[$question->id]->isNotEmpty())
                                            @foreach($results[$question->id] as $optionData)
                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-700">{{ $optionData['option'] }}</span>
                                                    <div class="flex items-center space-x-2">
                                                        <div class="w-32 bg-gray-200 rounded-full h-4">
                                                            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $survey->responses()->count() > 0 ? ($optionData['count'] / $survey->responses()->count()) * 100 : 0 }}%"></div>
                                                        </div>
                                                        <span class="text-sm text-gray-600 w-12 text-right">{{ $optionData['count'] }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-gray-500 italic">No responses yet.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 text-lg">No responses have been submitted yet.</p>
                            <p class="text-gray-400 mt-2">Share the survey link to start collecting responses.</p>
                        </div>
                    @endif

                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('surveys.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Surveys
                        </a>
                        <a href="{{ route('surveys.edit', $survey) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Survey
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
