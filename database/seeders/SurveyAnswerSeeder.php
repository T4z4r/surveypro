<?php

namespace Database\Seeders;

use App\Models\SurveyAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyAnswerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Answers for Response 1 (Customer Satisfaction Survey)
        SurveyAnswer::create([
            'survey_response_id' => 1,
            'survey_question_id' => 1,
            'answer' => 'Very Satisfied',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 1,
            'survey_question_id' => 2,
            'answer' => 'User Interface',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 1,
            'survey_question_id' => 3,
            'answer' => 'Great service overall!',
        ]);

        // Answers for Response 2 (Employee Engagement Survey)
        SurveyAnswer::create([
            'survey_response_id' => 2,
            'survey_question_id' => 4,
            'answer' => 'Good',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 2,
            'survey_question_id' => 5,
            'answer' => 'Career Growth',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 2,
            'survey_question_id' => 6,
            'answer' => 'More flexible hours would be nice.',
        ]);

        // Answers for Response 3 (Customer Satisfaction Survey)
        SurveyAnswer::create([
            'survey_response_id' => 3,
            'survey_question_id' => 1,
            'answer' => 'Satisfied',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 3,
            'survey_question_id' => 2,
            'answer' => 'Customer Support',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 3,
            'survey_question_id' => 3,
            'answer' => 'Could improve response times.',
        ]);

        // Answers for Response 4 (Employee Engagement Survey)
        SurveyAnswer::create([
            'survey_response_id' => 4,
            'survey_question_id' => 4,
            'answer' => 'Excellent',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 4,
            'survey_question_id' => 5,
            'answer' => 'Work Environment',
        ]);

        SurveyAnswer::create([
            'survey_response_id' => 4,
            'survey_question_id' => 6,
            'answer' => 'Everything is great!',
        ]);
    }
}