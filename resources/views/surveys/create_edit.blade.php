<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-3xl text-slate-800 dark:text-slate-200 leading-tight">
                    {{ $mode === 'edit' ? 'Edit Survey' : 'Create New Survey' }}
                </h2>
                <p class="mt-1 text-slate-600 dark:text-slate-400">{{ $mode === 'edit' ? 'Update your survey details and questions' : 'Build your survey with multiple question types' }}</p>
            </div>
        </div>
    </x-slot>

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

                    <form method="POST" action="{{ $mode === 'edit' ? route('surveys.update', $survey) : route('surveys.store') }}" id="surveyForm">
                        @csrf
                        @if($mode === 'edit')
                            @method('POST')
                        @endif

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                            <div class="lg:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Survey Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $survey->title ?? '') }}" required
                                       class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Status</label>
                                <select name="status" id="status" class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                                    <option value="draft" {{ old('status', $survey->status ?? 'draft') === 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                    <option value="active" {{ old('status', $survey->status ?? 'draft') === 'active' ? 'selected' : '' }}>🚀 Active</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label for="description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Description (Optional)</label>
                            <textarea name="description" id="description" rows="4"
                                      class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors resize-none"
                                      placeholder="Add a description to help respondents understand the purpose of your survey...">{{ old('description', $survey->description ?? '') }}</textarea>
                        </div>

                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Questions</h3>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Add and configure your survey questions</p>
                                </div>
                                <button type="button" id="addQuestion" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Question
                                </button>
                            </div>

                            <div id="questionsContainer" class="space-y-6">
                                @if($mode === 'edit' && $survey->questions)
                                    @foreach($survey->questions as $index => $question)
                                        <div class="question-item bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl p-6" data-question-id="{{ $question->id }}">
                                            <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                        <span class="text-white font-semibold text-sm">{{ $index + 1 }}</span>
                                                    </div>
                                                    <h4 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Question {{ $index + 1 }}</h4>
                                                </div>
                                                <button type="button" class="removeQuestion inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Remove
                                                </button>
                                            </div>

                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Question Text</label>
                                                    <input type="text" name="questions[{{ $index }}][question]" value="{{ $question->question }}" placeholder="Enter your question here..." required
                                                           class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Question Type</label>
                                                    <select name="questions[{{ $index }}][type]" class="question-type block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                                                        <option value="text" {{ $question->type === 'text' ? 'selected' : '' }}>📝 Text Answer</option>
                                                        <option value="radio" {{ $question->type === 'radio' ? 'selected' : '' }}>🔘 Single Choice (Radio)</option>
                                                        <option value="checkbox" {{ $question->type === 'checkbox' ? 'selected' : '' }}>☑️ Multiple Choice (Checkbox)</option>
                                                    </select>
                                                </div>

                                                <div class="options-container {{ $question->type === 'text' ? 'hidden' : '' }}">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Answer Options</label>
                                                        <button type="button" class="addOption inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                            Add Option
                                                        </button>
                                                    </div>
                                                    <div class="options-list space-y-3">
                                                        @if($question->options)
                                                            @foreach($question->options as $optIndex => $option)
                                                                <div class="option-item flex items-center space-x-3">
                                                                    <input type="hidden" name="questions[{{ $index }}][options][{{ $optIndex }}][id]" value="{{ $option->id }}">
                                                                    <input type="text" name="questions[{{ $index }}][options][{{ $optIndex }}][option_text]" value="{{ $option->option_text }}" placeholder="Enter option text..." required
                                                                           class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                                                                    <button type="button" class="removeOption inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('surveys.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-500 hover:bg-slate-600 text-white font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    optionsContainer.classList.add('hidden');
                } else {
                    optionsContainer.classList.remove('hidden');
                }
            }
        });

        function addQuestion(existingQuestion = null) {
            const container = document.getElementById('questionsContainer');
            const questionItem = document.createElement('div');
            questionItem.className = 'question-item bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 rounded-xl p-6';
            if (existingQuestion && existingQuestion.id) {
                questionItem.dataset.questionId = existingQuestion.id;
            }

            questionItem.innerHTML = `
                ${existingQuestion ? `<input type="hidden" name="questions[${questionIndex}][id]" value="${existingQuestion.id}">` : ''}
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">${questionIndex + 1}</span>
                        </div>
                        <h4 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Question ${questionIndex + 1}</h4>
                    </div>
                    <button type="button" class="removeQuestion inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Remove
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Question Text</label>
                        <input type="text" name="questions[${questionIndex}][question]" value="${existingQuestion ? existingQuestion.question : ''}" placeholder="Enter your question here..." required
                               class="block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Question Type</label>
                        <select name="questions[${questionIndex}][type]" class="question-type block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                            <option value="text" ${existingQuestion && existingQuestion.type === 'text' ? 'selected' : ''}>📝 Text Answer</option>
                            <option value="radio" ${existingQuestion && existingQuestion.type === 'radio' ? 'selected' : ''}>🔘 Single Choice (Radio)</option>
                            <option value="checkbox" ${existingQuestion && existingQuestion.type === 'checkbox' ? 'selected' : ''}>☑️ Multiple Choice (Checkbox)</option>
                        </select>
                    </div>

                    <div class="options-container ${existingQuestion && existingQuestion.type === 'text' ? 'hidden' : ''}">
                        <div class="flex justify-between items-center mb-4">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Answer Options</label>
                            <button type="button" class="addOption inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Option
                            </button>
                        </div>
                        <div class="options-list space-y-3">
                            ${existingQuestion && existingQuestion.options ? existingQuestion.options.map((option, optIndex) => `
                                <div class="option-item flex items-center space-x-3">
                                    <input type="hidden" name="questions[${questionIndex}][options][${optIndex}][id]" value="${option.id}">
                                    <input type="text" name="questions[${questionIndex}][options][${optIndex}][option_text]" value="${option.option_text}" placeholder="Enter option text..." required
                                           class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                                    <button type="button" class="removeOption inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            optionItem.className = 'option-item flex items-center space-x-3';
            optionItem.innerHTML = `
                <input type="text" name="questions[${questionIndex}][options][${optionIndex}][option_text]" placeholder="Enter option text..." required
                       class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 transition-colors">
                <button type="button" class="removeOption inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                question.querySelector('h4').textContent = `Question ${index + 1}`;
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
</x-app-layout>
