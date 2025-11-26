<?php
namespace App\Http\Controllers;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyOption;
use Illuminate\Http\Request;
use PDF; // from barryvdh/laravel-dompdf
use League\Csv\Writer;
use SplTempFileObject;

class SurveyResultsController extends Controller
{
    public function index(Survey $survey){
        $survey->load('questions.options');

        $results = [];
        foreach($survey->questions as $q){
            if($q->type === 'text'){
                $answers = SurveyAnswer::where('survey_question_id',$q->id)->pluck('answer')->filter()->values();
                $results[$q->id] = $answers;
            } else {
                // build option counts
                $rows = [];
                foreach($q->options as $opt){
                    // for radio and checkbox we stored selected option ids or JSON
                    $count = SurveyAnswer::where('survey_question_id',$q->id)
                              ->where(function($query) use ($opt){
                                  $query->where('answer', (string)$opt->id)
                                        ->orWhereJsonContains('answer', (int)$opt->id);
                              })->count();
                    $rows[] = ['option'=>$opt->option_text,'count'=>$count,'id'=>$opt->id];
                }
                $results[$q->id] = collect($rows);
            }
        }

        return view('surveys.results', compact('survey','results'));
    }

    public function exportPdf(Survey $survey){
        $survey->load('questions.options');
        $view = view('surveys.results_pdf', compact('survey'))->render();
        $pdf = PDF::loadHTML($view);
        return $pdf->download(str_replace(' ','_',$survey->title).'_results.pdf');
    }

    public function exportCsv(Survey $survey){
        $survey->load('questions.options');

        $csv = Writer::createFromFileObject(new SplTempFileObject());
        // header: survey title + question headers
        $headers = ['response_id','user_id','submitted_at'];
        // We'll flatten answers by question id
        foreach($survey->questions as $q){
            $headers[] = 'q_'.$q->id;
        }
        $csv->insertOne($headers);

        $responses = $survey->responses()->with('answers')->get();
        foreach($responses as $resp){
            $row = [$resp->id, $resp->user_id, $resp->created_at];
            foreach($survey->questions as $q){
                $ans = $resp->answers->firstWhere('survey_question_id',$q->id);
                $row[] = $ans ? $ans->answer : '';
            }
            $csv->insertOne($row);
        }

        $filename = str_replace(' ','_',$survey->title).'_results.csv';
        return response((string)$csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}"
        ]);
    }
}
