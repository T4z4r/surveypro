@extends('layouts.app')

@section('header')
{!! view('components.survey-header', [
    'title' => $mode === 'edit' ? 'Edit Survey' : 'Create New Survey',
    'description' => $mode === 'edit' ? 'Update your survey details and questions' : 'Build your survey with multiple question types',
    'bgColor' => 'primary',
    'iconPath' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
]) !!}
@endsection

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

                    <form method="POST" action="{{ $mode === 'edit' ? route('surveys.update', $survey) : route('surveys.store') }}" id="surveyForm">
                        @csrf
                        @if($mode === 'edit')
                            @method('PUT')
                        @endif

                        <div class="row g-3 mb-4">
                            <div class="col-12 col-lg-8">
                                <label for="title" class="form-label fw-semibold text-dark">Survey Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $survey->title ?? '') }}" required
                                       class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <svg class="me-1" width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-4">
                                <label for="status" class="form-label fw-semibold text-dark">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="draft" {{ old('status', $survey->status ?? 'draft') === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                    <option value="active" {{ old('status', $survey->status ?? 'draft') === 'active' ? 'selected' : '' }}>🚀 Active</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold text-dark">Description (Optional)</label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control" style="resize: none;"
                                      placeholder="Add a description to help respondents understand the purpose of your survey...">{{ old('description', $survey->description ?? '') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="fs-4 fw-bold text-dark">Questions</h3>
                                    <p class="text-muted fs-6 mt-1">Add and configure your survey questions</p>
                                </div>
                                <button type="button" id="addQuestion" class="btn btn-success d-inline-flex align-items-center">
                                    <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Question
                                </button>
                            </div>

                            <div id="questionsContainer">
                                @if($mode === 'edit' && $survey->questions)
                                    @foreach($survey->questions as $index => $question)
                                        <div class="question-item bg-light border rounded p-3 mb-4" data-question-id="{{ $question->id }}">
                                            <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary rounded d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                                                        <span class="text-white fw-semibold fs-6">{{ $index + 1 }}</span>
                                                    </div>
                                                    <h4 class="fs-5 fw-semibold text-dark mb-0">Question {{ $index + 1 }}</h4>
                                                </div>
                                                <button type="button" class="removeQuestion btn btn-danger btn-sm d-inline-flex align-items-center">
                                                    <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Remove
                                                </button>
                                            </div>

                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-medium text-dark">Question Text</label>
                                                    <input type="text" name="questions[{{ $index }}][question]" value="{{ $question->question }}" placeholder="Enter your question here..." required
                                                           class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-medium text-dark">Question Type</label>
                                                    <select name="questions[{{ $index }}][type]" class="question-type form-select">
                                                        <option value="text" {{ $question->type === 'text' ? 'selected' : '' }}>📝 Text Answer</option>
                                                        <option value="radio" {{ $question->type === 'radio' ? 'selected' : '' }}>🔘 Single Choice (Radio)</option>
                                                        <option value="checkbox" {{ $question->type === 'checkbox' ? 'selected' : '' }}>☑️ Multiple Choice (Checkbox)</option>
                                                    </select>
                                                </div>

                                                <div class="options-container {{ $question->type === 'text' ? 'd-none' : '' }}">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <label class="fw-semibold text-dark fs-6">Answer Options</label>
                                                        <button type="button" class="addOption btn btn-primary btn-sm d-inline-flex align-items-center">
                                                            <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                            Add Option
                                                        </button>
                                                    </div>
                                                    <div class="options-list">
                                                        @if($question->options)
                                                            @foreach($question->options as $optIndex => $option)
                                                                <div class="option-item d-flex align-items-center mb-2">
                                                                    <input type="hidden" name="questions[{{ $index }}][options][{{ $optIndex }}][id]" value="{{ $option->id }}">
                                                                    <input type="text" name="questions[{{ $index }}][options][{{ $optIndex }}][option_text]" value="{{ $option->option_text }}" placeholder="Enter option text..." required
                                                                           class="form-control me-2">
                                                                    <button type="button" class="removeOption btn btn-danger btn-sm">
                                                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 pt-3 border-top">
                            <a href="{{ route('surveys.index') }}" class="btn btn-secondary d-inline-flex align-items-center justify-content-center">
                                <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center justify-content-center">
                                <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ $mode === 'edit' ? 'Update Survey' : 'Create Survey' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let questionIndex = {{ $mode === 'edit' ? $survey->questions->count() : 0 }};
        let optionIndices = {};
        @if($mode === 'edit' && $survey->questions)
            @foreach($survey->questions as $index => $question)
                optionIndices[{{ $index }}] = {{ $question->options->count() }};
            @endforeach
        @endif

        document.getElementById('addQuestion').addEventListener('click', function() {
            addQuestion();
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeQuestion')) {
                e.target.closest('.question-item').remove();
                reorderQuestions();
            }
            if (e.target.classList.contains('addOption')) {
                const questionItem = e.target.closest('.question-item');
                const questionId = questionItem.dataset.questionId || questionItem.querySelector('input[name*="[id]"]')?.value;
                addOption(questionItem, questionId);
            }
            if (e.target.classList.contains('removeOption')) {
                e.target.closest('.option-item').remove();
                reorderOptions(e.target.closest('.question-item'));
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('question-type')) {
                const questionItem = e.target.closest('.question-item');
                const optionsContainer = questionItem.querySelector('.options-container');
                if (e.target.value === 'text') {
                    optionsContainer.classList.add('d-none');
                } else {
                    optionsContainer.classList.remove('d-none');
                }
            }
        });

        function addQuestion(existingQuestion = null) {
            const container = document.getElementById('questionsContainer');
            const questionItem = document.createElement('div');
            questionItem.className = 'question-item bg-light border rounded p-3 mb-4';
            if (existingQuestion && existingQuestion.id) {
                questionItem.dataset.questionId = existingQuestion.id;
            }

            questionItem.innerHTML = `
                ${existingQuestion ? `<input type="hidden" name="questions[${questionIndex}][id]" value="${existingQuestion.id}">` : ''}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                            <span class="text-white fw-semibold fs-6">${questionIndex + 1}</span>
                        </div>
                        <h4 class="fs-5 fw-semibold text-dark mb-0">Question ${questionIndex + 1}</h4>
                    </div>
                    <button type="button" class="removeQuestion btn btn-danger btn-sm d-inline-flex align-items-center">
                        <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Remove
                    </button>
                </div>

                <div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Question Text</label>
                        <input type="text" name="questions[${questionIndex}][question]" value="${existingQuestion ? existingQuestion.question : ''}" placeholder="Enter your question here..." required
                               class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium text-dark">Question Type</label>
                        <select name="questions[${questionIndex}][type]" class="question-type form-select">
                            <option value="text" ${existingQuestion && existingQuestion.type === 'text' ? 'selected' : ''}>📝 Text Answer</option>
                            <option value="radio" ${existingQuestion && existingQuestion.type === 'radio' ? 'selected' : ''}>🔘 Single Choice (Radio)</option>
                            <option value="checkbox" ${existingQuestion && existingQuestion.type === 'checkbox' ? 'selected' : ''}>☑️ Multiple Choice (Checkbox)</option>
                        </select>
                    </div>

                    <div class="options-container ${existingQuestion && existingQuestion.type === 'text' ? 'd-none' : ''}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="fw-semibold text-dark fs-6">Answer Options</label>
                            <button type="button" class="addOption btn btn-primary btn-sm d-inline-flex align-items-center">
                                <svg class="me-1" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Option
                            </button>
                        </div>
                        <div class="options-list">
                            ${existingQuestion && existingQuestion.options ? existingQuestion.options.map((option, optIndex) => `
                                <div class="option-item d-flex align-items-center mb-2">
                                    <input type="hidden" name="questions[${questionIndex}][options][${optIndex}][id]" value="${option.id}">
                                    <input type="text" name="questions[${questionIndex}][options][${optIndex}][option_text]" value="${option.option_text}" placeholder="Enter option text..." required
                                           class="form-control me-2">
                                    <button type="button" class="removeOption btn btn-danger btn-sm">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            `).join('') : ''}
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(questionItem);
            if (existingQuestion && existingQuestion.options) {
                optionIndices[questionIndex] = existingQuestion.options.length;
            } else {
                optionIndices[questionIndex] = 0;
            }
            questionIndex++;
        }

        function addOption(questionItem, questionId) {
            const optionsList = questionItem.querySelector('.options-list');
            const questionIndex = Array.from(questionItem.parentNode.children).indexOf(questionItem);
            const optionIndex = optionIndices[questionIndex] || 0;

            const optionItem = document.createElement('div');
            optionItem.className = 'option-item d-flex align-items-center mb-2';
            optionItem.innerHTML = `
                <input type="text" name="questions[${questionIndex}][options][${optionIndex}][option_text]" placeholder="Enter option text..." required
                       class="form-control me-2">
                <button type="button" class="removeOption btn btn-danger btn-sm">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            optionsList.appendChild(optionItem);
            optionIndices[questionIndex] = optionIndex + 1;
        }

        function reorderQuestions() {
            const questions = document.querySelectorAll('.question-item');
            questions.forEach((question, index) => {
                const questionNumber = index + 1;
                question.querySelector('h4').textContent = `Question ${questionNumber}`;
                question.querySelector('.bg-primary span').textContent = questionNumber;
                // Update input names if needed
            });
        }

        function reorderOptions(questionItem) {
            const options = questionItem.querySelectorAll('.option-item');
            options.forEach((option, index) => {
                // Update input names if needed
            });
        }
    </script>
@endsection
