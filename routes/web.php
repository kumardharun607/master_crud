<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/state', [StateController::class, 'index']);

Route::post('/state', [StateController::class, 'store']);

Route::get('/state/list', [StateController::class, 'list']);

Route::get('/state/{id}/edit', [StateController::class, 'edit']);

Route::put('/state/{id}', [StateController::class, 'update']);

Route::delete('/state/{id}', [StateController::class, 'destroy']);