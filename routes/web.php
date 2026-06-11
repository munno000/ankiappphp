<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\WordController;

Route::get('/', function () {
    return redirect(url('/sections'));
});

Route::get('/sections', [SectionController::class, 'index']);
Route::post('/sections', [SectionController::class, 'store']);
Route::put('/sections/{id}', [SectionController::class, 'update']);
Route::delete('/sections/{id}', [SectionController::class, 'destroy']);

Route::get('/words', [WordController::class, 'index']);
Route::post('/words', [WordController::class, 'store']);
Route::get('/words/{id}/edit', [WordController::class, 'edit']);
Route::put('/words/{id}', [WordController::class, 'update']);
Route::delete('/words/{id}', [WordController::class, 'destroy']);

Route::get('/quiz', [WordController::class, 'quiz']);
Route::post('/quiz/check', [WordController::class, 'check']);
