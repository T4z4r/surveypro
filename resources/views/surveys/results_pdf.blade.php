<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $survey->title }} - Results</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; border-bottom: 2px solid #333; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        h3 { color: #666; margin-top: 20px; }
        .question { margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .text-response { background-color: #f9f9f9; padding: 10px; margin: 5px 0; border-radius: 3px; }
        .option-result { display: flex; justify-content: space-between; align-items: center; margin: 5px 0; }
        .bar { height: 20px; background-color: #e0e0e0; border-radius: 10px; margin: 0 10px; flex: 1; }
        .bar-fill { height: 100%; background-color: #007bff; border-radius: 10px; }
        .count { font-weight: bold; min-width: 30px; text-align: right; }
        .summary { background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>{{ $survey->title }}</h1>
    @if($survey->description)
        <p>{{ $survey->description }}</p>
    @endif

    <div class="summary">
        <strong>Total Responses:</strong> {{ $survey->responses()->count() }}<br>
        <strong>Generated on:</strong> {{ now()->format('F j, Y \a\t g:i A') }}
    </div>

    @if($survey->responses()->count() > 0)
        @foreach($survey->questions as $question)
            <div class="question">
                <h3>{{ $question->question }}</h3>

                @if($question->type === 'text')
                    <div>
                        @if(isset($results[$question->id]) && $results[$question->id]->isNotEmpty())
                            @foreach($results[$question->id] as $answer)
                                <div class="text-response">
                                    {{ $answer ?: '(No answer)' }}
                                </div>
                            @endforeach
                        @else
                            <p><em>No responses yet.</em></p>
                        @endif
                    </div>

                @else
                    <div>
                        @if(isset($results[$question->id]) && $results[$question->id]->isNotEmpty())
                            @foreach($results[$question->id] as $optionData)
                                <div class="option-result">
                                    <span>{{ $optionData['option'] }}</span>
                                    <div class="bar">
                                        <div class="bar-fill" style="width: {{ $survey->responses()->count() > 0 ? ($optionData['count'] / $survey->responses()->count()) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="count">{{ $optionData['count'] }}</span>
                                </div>
                            @endforeach
                        @else
                            <p><em>No responses yet.</em></p>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <p>No responses have been submitted yet.</p>
    @endif
</body>
</html>