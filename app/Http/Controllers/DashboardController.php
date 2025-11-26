<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get stats
        $totalSurveys = Survey::count();
        $totalResponses = SurveyResponse::count();
        $activeSurveys = Survey::where('status', 'active')->count();

        // Get recent surveys (last 5)
        $recentSurveys = Survey::latest()->take(5)->get();

        return view('dashboard', compact('totalSurveys', 'totalResponses', 'activeSurveys', 'recentSurveys'));
    }
}