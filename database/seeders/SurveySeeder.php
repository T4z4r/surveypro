<?php

namespace Database\Seeders;

use App\Models\Survey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Survey::create([
            'title' => 'Customer Satisfaction Survey',
            'description' => 'Help us improve our services by sharing your feedback.',
            'status' => 'active',
        ]);

        Survey::create([
            'title' => 'Employee Engagement Survey',
            'description' => 'Tell us about your work experience and suggestions.',
            'status' => 'active',
        ]);

        Survey::create([
            'title' => 'Product Feedback Survey',
            'description' => 'Share your thoughts on our latest product release.',
            'status' => 'inactive',
        ]);
    }
}