<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\WordController;

Route::get('/', fn() => redirect(url('/books')));

// Books
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}/edit', [BookController::class, 'edit']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::put('/books/{id}/sections', [BookController::class, 'updateSections']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);

// Sections (nested under book)
Route::get('/books/{bookId}/sections', [SectionController::class, 'index']);
Route::post('/books/{bookId}/sections', [SectionController::class, 'store']);
Route::put('/books/{bookId}/sections/{id}', [SectionController::class, 'update']);
Route::delete('/books/{bookId}/sections/{id}', [SectionController::class, 'destroy']);

// Words & Quiz
Route::get('/words', [WordController::class, 'index']);
Route::post('/words', [WordController::class, 'store']);
Route::get('/words/{id}/edit', [WordController::class, 'edit']);
Route::put('/words/{id}', [WordController::class, 'update']);
Route::delete('/words/{id}', [WordController::class, 'destroy']);
Route::get('/quiz', [WordController::class, 'quiz']);
Route::post('/quiz/check', [WordController::class, 'check']);
