<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\WordController;

Route::get('/words', [WordController::class, 'index']);
Route::post('/words', [WordController::class, 'store']);
Route::get('/quiz', [WordController::class, 'quiz']);
Route::post('/quiz/check', [WordController::class, 'check']);
