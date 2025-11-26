<?php

namespace Database\Seeders;

use App\Models\SurveyOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyOptionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Options for Question 1: How satisfied are you with our overall service?
        SurveyOption::create([
            'survey_question_id' => 1,
            'option_text' => 'Very Satisfied',
        ]);

        SurveyOption::create([
            'survey_question_id' => 1,
            'option_text' => 'Satisfied',
        ]);

        SurveyOption::create([
            'survey_question_id' => 1,
            'option_text' => 'Neutral',
        ]);

        SurveyOption::create([
            'survey_question_id' => 1,
            'option_text' => 'Dissatisfied',
        ]);

        SurveyOption::create([
            'survey_question_id' => 1,
            'option_text' => 'Very Dissatisfied',
        ]);

        // Options for Question 2: What is your favorite feature?
        SurveyOption::create([
            'survey_question_id' => 2,
            'option_text' => 'User Interface',
        ]);

        SurveyOption::create([
            'survey_question_id' => 2,
            'option_text' => 'Customer Support',
        ]);

        SurveyOption::create([
            'survey_question_id' => 2,
            'option_text' => 'Features',
        ]);

        SurveyOption::create([
            'survey_question_id' => 2,
            'option_text' => 'Pricing',
        ]);

        // Options for Question 4: How would you rate your work-life balance?
        SurveyOption::create([
            'survey_question_id' => 4,
            'option_text' => 'Excellent',
        ]);

        SurveyOption::create([
            'survey_question_id' => 4,
            'option_text' => 'Good',
        ]);

        SurveyOption::create([
            'survey_question_id' => 4,
            'option_text' => 'Average',
        ]);

        SurveyOption::create([
            'survey_question_id' => 4,
            'option_text' => 'Poor',
        ]);

        // Options for Question 5: What motivates you most at work?
        SurveyOption::create([
            'survey_question_id' => 5,
            'option_text' => 'Salary',
        ]);

        SurveyOption::create([
            'survey_question_id' => 5,
            'option_text' => 'Career Growth',
        ]);

        SurveyOption::create([
            'survey_question_id' => 5,
            'option_text' => 'Work Environment',
        ]);

        SurveyOption::create([
            'survey_question_id' => 5,
            'option_text' => 'Recognition',
        ]);

        // Options for Question 7: How often do you use our product?
        SurveyOption::create([
            'survey_question_id' => 7,
            'option_text' => 'Daily',
        ]);

        SurveyOption::create([
            'survey_question_id' => 7,
            'option_text' => 'Weekly',
        ]);

        SurveyOption::create([
            'survey_question_id' => 7,
            'option_text' => 'Monthly',
        ]);

        SurveyOption::create([
            'survey_question_id' => 7,
            'option_text' => 'Rarely',
        ]);
    }
}