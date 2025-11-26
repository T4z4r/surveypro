<?php
namespace App\Http\Controllers;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index(){
        $surveys = Survey::latest()->paginate(12);
        return view('surveys.index', compact('surveys'));
    }

    public function create(){
        return view('surveys.create_edit')->with(['survey'=>new Survey(),'mode'=>'create']);
    }

    public function store(Request $r){
        $r->validate([
            'title'=>'required|string|max:255',
            'questions'=>'required|array|min:1',
            'questions.*.question'=>'required|string',
            'questions.*.type'=>'required|in:text,radio,checkbox'
        ]);

        DB::transaction(function() use ($r){
            $s = Survey::create($r->only('title','description','status'));

            foreach ($r->questions as $q){
                $question = $s->questions()->create([
                    'question'=>$q['question'],
                    'type'=>$q['type']
                ]);
                if(isset($q['options']) && in_array($q['type'], ['radio','checkbox'])){
                    foreach($q['options'] as $opt){
                        $question->options()->create(['option_text'=>$opt]);
                    }
                }
            }
        });

        return redirect()->route('surveys.index')->with('success','Survey created.');
    }

    public function edit(Survey $survey){
        $survey->load('questions.options');
        return view('surveys.create_edit', ['survey'=>$survey,'mode'=>'edit']);
    }

    public function update(Request $r, Survey $survey){
        $r->validate([
            'title'=>'required|string|max:255',
            'questions'=>'required|array|min:1',
            'questions.*.question'=>'required|string',
            'questions.*.type'=>'required|in:text,radio,checkbox'
        ]);

        DB::transaction(function() use ($r,$survey){
            $survey->update($r->only('title','description','status'));

            $keepQ = [];
            foreach($r->questions as $q){
                if(!empty($q['id'])){
                    $question = SurveyQuestion::find($q['id']);
                    if($question){
                        $question->update(['question'=>$q['question'],'type'=>$q['type']]);
                    } else {
                        $question = $survey->questions()->create(['question'=>$q['question'],'type'=>$q['type']]);
                    }
                } else {
                    $question = $survey->questions()->create(['question'=>$q['question'],'type'=>$q['type']]);
                }
                $keepQ[] = $question->id;

                // options
                if(in_array($q['type'], ['radio','checkbox'])){
                    $keepO = [];
                    if(!empty($q['options'])){
                        foreach($q['options'] as $opt){
                            if(!empty($opt['id'])){
                                $o = SurveyOption::find($opt['id']);
                                if($o) { $o->update(['option_text'=>$opt['option_text']]); }
                                else { $o = $question->options()->create(['option_text'=>$opt['option_text']]); }
                            } else {
                                $o = $question->options()->create(['option_text'=>$opt['option_text']]);
                            }
                            $keepO[] = $o->id;
                        }
                    }
                    SurveyOption::where('survey_question_id',$question->id)->whereNotIn('id',$keepO)->delete();
                } else {
                    // remove existing options if question changed to text
                    SurveyOption::where('survey_question_id',$question->id)->delete();
                }
            }
            SurveyQuestion::where('survey_id',$survey->id)->whereNotIn('id',$keepQ)->delete();
        });

        return redirect()->route('surveys.index')->with('success','Survey updated.');
    }

    public function destroy(Survey $survey){
        $survey->delete();
        return redirect()->route('surveys.index')->with('success','Survey deleted.');
    }

    public function duplicate(Survey $survey){
        DB::transaction(function() use ($survey){
            $copy = $survey->replicate();
            $copy->title = $survey->title . ' (Copy)';
            $copy->push(); // save

            foreach($survey->questions as $q){
                $newQ = $q->replicate();
                $newQ->survey_id = $copy->id;
                $newQ->push();
                foreach($q->options as $opt){
                    $newOpt = $opt->replicate();
                    $newOpt->survey_question_id = $newQ->id;
                    $newOpt->push();
                }
            }
        });

        return redirect()->route('surveys.index')->with('success','Survey duplicated.');
    }
}
