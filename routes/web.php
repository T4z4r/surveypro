<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyResponseController;
use App\Http\Controllers\SurveyResultsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/surveys', [SurveyController::class,'index'])->name('surveys.index');
    Route::get('/surveys/create', [SurveyController::class,'create'])->name('surveys.create');
    Route::post('/surveys/store', [SurveyController::class,'store'])->name('surveys.store');
    Route::get('/surveys/{survey}/edit', [SurveyController::class,'edit'])->name('surveys.edit');
    Route::post('/surveys/{survey}/update', [SurveyController::class,'update'])->name('surveys.update');
    Route::post('/surveys/{survey}/delete', [SurveyController::class,'destroy'])->name('surveys.destroy');
    Route::post('/surveys/{survey}/duplicate', [SurveyController::class,'duplicate'])->name('surveys.duplicate');

    // results and exports
    Route::get('/surveys/{survey}/results', [SurveyResultsController::class,'index'])->name('surveys.results');
    Route::get('/surveys/{survey}/results/pdf', [SurveyResultsController::class,'exportPdf'])->name('surveys.results.pdf');
    Route::get('/surveys/{survey}/results/csv', [SurveyResultsController::class,'exportCsv'])->name('surveys.results.csv');
});

// allow filling for authenticated users; if you want guests, remove middleware
Route::middleware(['auth'])->group(function() {
    Route::get('/surveys/{survey}/take', [SurveyResponseController::class,'show'])->name('surveys.take');
    Route::post('/surveys/{survey}/submit', [SurveyResponseController::class,'store'])->name('surveys.submit');
});


require __DIR__.'/auth.php';
