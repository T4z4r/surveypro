@extends('layouts.app')

@section('content')
<div class="py-5">
        <div class="container-fluid px-3 px-lg-5">
            <div class="bg-white overflow-hidden shadow rounded border">
                <div class="p-4">
                    @if(session('success'))
                        <div class="bg-success bg-opacity-10 border border-success text-success p-3 rounded mb-4 d-flex align-items-center">
                            <svg class="me-3 flex-shrink-0" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-danger bg-opacity-10 border border-danger text-danger p-3 rounded mb-4 d-flex align-items-center">
                            <svg class="me-3 flex-shrink-0" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($survey->description)
                        <div class="mb-4 p-3 bg-light rounded border border-primary">
                            <div class="d-flex align-items-start">
                                <svg class="me-3 flex-shrink-0 mt-1" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="fs-5 fw-semibold text-dark mb-2">Survey Description</h3>
                                    <p class="text-muted">{{ $survey->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('surveys.submit', $survey) }}">
                        @csrf

                        <div>
                            @foreach($survey->questions as $index => $question)
                                <div class="bg-light rounded p-3 border mb-4">
                                    <div class="d-flex align-items-start">
                                        <div class="bg-primary rounded d-flex align-items-center justify-content-center flex-shrink-0 me-3" style="width: 32px; height: 32px;">
                                            <span class="text-white fw-semibold fs-6">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h3 class="fs-4 fw-semibold text-dark mb-3">{{ $question->question }}</h3>

                                            @if($question->type === 'text')
                                                 <textarea name="answers[{{ $question->id }}][answer]" rows="4" placeholder="Type your answer here..."
                                                           class="form-control @error("answers.{$question->id}.answer") is-invalid @enderror" style="resize: none;"></textarea>
                                                 @error("answers.{$question->id}.answer")
                                                     <div class="invalid-feedback d-flex align-items-center">
                                                         <svg class="me-1" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                                             <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                         </svg>
                                                         {{ $message }}
                                                     </div>
                                                 @enderror

                                            @elseif($question->type === 'radio')
                                                <div>
                                                    @foreach($question->options as $option)
                                                        <div class="form-check p-2 bg-white rounded border mb-2">
                                                            <input type="radio" name="answers[{{ $question->id }}][selected]" value="{{ $option->id }}" id="option_{{ $option->id }}"
                                                                   class="form-check-input @error("answers.{$question->id}.selected") is-invalid @enderror">
                                                            <label for="option_{{ $option->id }}" class="form-check-label fw-medium text-dark cursor-pointer">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error("answers.{$question->id}.selected")
                                                    <div class="invalid-feedback d-flex align-items-center">
                                                        <svg class="me-1" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                            @elseif($question->type === 'checkbox')
                                                <div>
                                                    @foreach($question->options as $option)
                                                        <div class="form-check p-2 bg-white rounded border mb-2">
                                                            <input type="checkbox" name="answers[{{ $question->id }}][selected][]" value="{{ $option->id }}" id="option_{{ $option->id }}"
                                                                   class="form-check-input @error("answers.{$question->id}.selected") is-invalid @enderror">
                                                            <label for="option_{{ $option->id }}" class="form-check-label fw-medium text-dark cursor-pointer">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error("answers.{$question->id}.selected")
                                                    <div class="invalid-feedback d-flex align-items-center">
                                                        <svg class="me-1" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            @endif
                                        </div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>

                         <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 pt-4 border-top mt-4">
                             <a href="{{ route('surveys.index') }}" class="btn btn-secondary d-inline-flex align-items-center justify-content-center">
                                 <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                 </svg>
                                 Back to Surveys
                             </a>
                             <button type="submit" class="btn btn-success d-inline-flex align-items-center justify-content-center">
                                 <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                 </svg>
                                 Submit Survey
                             </button>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
