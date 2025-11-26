<?php

namespace Database\Seeders;

use App\Models\SurveyResponse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveyResponseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Responses for Customer Satisfaction Survey (ID: 1)
        SurveyResponse::create([
            'survey_id' => 1,
            'user_id' => 1, // Test User
        ]);

        // Responses for Employee Engagement Survey (ID: 2)
        SurveyResponse::create([
            'survey_id' => 2,
            'user_id' => 1, // Test User
        ]);

        // Additional responses (simulating multiple users)
        SurveyResponse::create([
            'survey_id' => 1,
            'user_id' => 2, // John Doe
        ]);

        SurveyResponse::create([
            'survey_id' => 2,
            'user_id' => 2, // John Doe
        ]);
    }
}