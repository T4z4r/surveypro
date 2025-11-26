<?php
namespace App\Http\Controllers;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyResponseController extends Controller
{
    public function show(Survey $survey){
        $survey->load('questions.options');
        if($survey->status !== 'active'){
            return redirect()->route('surveys.index')->with('error','Survey is not active.');
        }
        return view('surveys.take', compact('survey'));
    }

    public function store(Request $r, Survey $survey){
        $user = $r->user();
        // prevent duplicates if you set unique constraint
        if($user && SurveyResponse::where('survey_id',$survey->id)->where('user_id',$user->id)->exists()){
            return redirect()->route('surveys.index')->with('error','You have already submitted this survey.');
        }

        $r->validate($this->buildValidation($survey));

        DB::transaction(function() use ($r,$survey,$user){
            $resp = SurveyResponse::create(['survey_id'=>$survey->id,'user_id'=>$user?->id]);
            foreach($survey->questions as $q){
                $answerValue = null;
                if($q->type === 'text'){
                    $answerValue = $r->input("answers.{$q->id}.answer") ?? null;
                } elseif($q->type === 'radio'){
                    $sel = $r->input("answers.{$q->id}.selected");
                    $answerValue = $sel ? (string)$sel : null; // store option id or text as you prefer
                } elseif($q->type === 'checkbox'){
                    $sel = $r->input("answers.{$q->id}.selected", []);
                    $answerValue = is_array($sel) ? json_encode($sel) : ($sel ? (string)$sel : null);
                }

                SurveyAnswer::create([
                    'survey_response_id'=>$resp->id,
                    'survey_question_id'=>$q->id,
                    'answer'=>$answerValue
                ]);
            }
        });

        return redirect()->route('surveys.index')->with('success','Thank you — responses saved.');
    }

    protected function buildValidation(Survey $survey){
        $rules = [];
        foreach($survey->questions as $q){
            if($q->type === 'text'){
                $rules["answers.{$q->id}.answer"] = 'nullable|string';
            } elseif($q->type === 'radio'){
                $rules["answers.{$q->id}.selected"] = 'nullable|integer|exists:survey_options,id';
            } elseif($q->type === 'checkbox'){
                $rules["answers.{$q->id}.selected"] = 'nullable|array';
                $rules["answers.{$q->id}.selected.*"] = 'integer|exists:survey_options,id';
            }
        }
        return $rules;
    }
}
