<?php

namespace Database\Seeders;

use App\Models\SurveyQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyQuestionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Questions for Customer Satisfaction Survey (ID: 1)
        SurveyQuestion::create([
            'survey_id' => 1,
            'question' => 'How satisfied are you with our overall service?',
            'type' => 'radio',
        ]);

        SurveyQuestion::create([
            'survey_id' => 1,
            'question' => 'What is your favorite feature?',
            'type' => 'radio',
        ]);

        SurveyQuestion::create([
            'survey_id' => 1,
            'question' => 'Any additional comments?',
            'type' => 'text',
        ]);

        // Questions for Employee Engagement Survey (ID: 2)
        SurveyQuestion::create([
            'survey_id' => 2,
            'question' => 'How would you rate your work-life balance?',
            'type' => 'radio',
        ]);

        SurveyQuestion::create([
            'survey_id' => 2,
            'question' => 'What motivates you most at work?',
            'type' => 'radio',
        ]);

        SurveyQuestion::create([
            'survey_id' => 2,
            'question' => 'Suggestions for improvement?',
            'type' => 'text',
        ]);

        // Questions for Product Feedback Survey (ID: 3)
        SurveyQuestion::create([
            'survey_id' => 3,
            'question' => 'How often do you use our product?',
            'type' => 'radio',
        ]);

        SurveyQuestion::create([
            'survey_id' => 3,
            'question' => 'What features would you like to see added?',
            'type' => 'text',
        ]);
    }
}