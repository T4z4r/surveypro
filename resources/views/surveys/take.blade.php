@extends('layouts.app')

@section('header')
{!! view('components.survey-header', [
    'title' => $survey->title,
    'description' => 'Fill out this survey',
    'bgColor' => 'success',
    'iconPath' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
]) !!}
@endsection

@section('content')
<div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-2xl border border-slate-200 dark:border-slate-700">
                <div class="p-8">
                    @if(session('success'))
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-xl mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-6 py-4 rounded-xl mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($survey->description)
                        <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                            <div class="flex items-start space-x-3">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200 mb-2">Survey Description</h3>
                                    <p class="text-slate-700 dark:text-slate-300">{{ $survey->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('surveys.submit', $survey) }}">
                        @csrf

                        <div class="space-y-8">
                            @foreach($survey->questions as $index => $question)
                                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-6 border border-slate-200 dark:border-slate-600">
                                    <div class="flex items-start space-x-4">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-4">{{ $question->question }}</h3>

                                            @if($question->type === 'text')
                                                <textarea name="answers[{{ $question->id }}][answer]" rows="4" placeholder="Type your answer here..."
                                                          class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors resize-none"
                                                          @if($errors->has("answers.{$question->id}.answer")) style="border-color: #ef4444;" @endif></textarea>
                                                @error("answers.{$question->id}.answer")
                                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror

                                            @elseif($question->type === 'radio')
                                                <div class="space-y-3">
                                                    @foreach($question->options as $option)
                                                        <div class="flex items-center p-3 bg-white dark:bg-slate-600 rounded-lg border border-slate-200 dark:border-slate-500 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                                                            <input type="radio" name="answers[{{ $question->id }}][selected]" value="{{ $option->id }}" id="option_{{ $option->id }}"
                                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 dark:border-slate-500"
                                                                   @if($errors->has("answers.{$question->id}.selected")) style="border-color: #ef4444;" @endif>
                                                            <label for="option_{{ $option->id }}" class="ml-3 block text-sm font-medium text-slate-900 dark:text-slate-100 cursor-pointer">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error("answers.{$question->id}.selected")
                                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror

                                            @elseif($question->type === 'checkbox')
                                                <div class="space-y-3">
                                                    @foreach($question->options as $option)
                                                        <div class="flex items-center p-3 bg-white dark:bg-slate-600 rounded-lg border border-slate-200 dark:border-slate-500 hover:border-blue-300 dark:hover:border-blue-500 transition-colors">
                                                            <input type="checkbox" name="answers[{{ $question->id }}][selected][]" value="{{ $option->id }}" id="option_{{ $option->id }}"
                                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 dark:border-slate-500 rounded"
                                                                   @if($errors->has("answers.{$question->id}.selected")) style="border-color: #ef4444;" @endif>
                                                            <label for="option_{{ $option->id }}" class="ml-3 block text-sm font-medium text-slate-900 dark:text-slate-100 cursor-pointer">
                                                                {{ $option->option_text }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error("answers.{$question->id}.selected")
                                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t border-slate-200 dark:border-slate-700 mt-8">
                            <a href="{{ route('surveys.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Surveys
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
