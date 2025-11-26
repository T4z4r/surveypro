<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Results: {{ $survey->title }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('surveys.results.pdf', $survey) }}" target="_blank"
                   class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Export PDF
                </a>
                <a href="{{ route('surveys.results.csv', $survey) }}"
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Export CSV
                </a>
            </div>
        </div>
    </x-slot>

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
</x-app-layout>
