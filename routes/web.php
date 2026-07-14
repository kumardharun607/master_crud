<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
// Redirect Home
use App\Http\Controllers\StateController;
Route::get('/', function () {
    return redirect('/country');
});
Route::get('/country', [CountryController::class, 'index']);

Route::post('/country/store', [CountryController::class, 'store']);

Route::get('/country/edit/{id}', [CountryController::class, 'edit']);

Route::post('/country/update/{id}', [CountryController::class, 'update']);

Route::delete('/country/delete/{id}', [CountryController::class, 'destroy']);

Route::get('/state', [StateController::class, 'index']);

Route::post('/state', [StateController::class, 'store']);

Route::get('/state/list', [StateController::class, 'list']);

Route::get('/state/{id}/edit', [StateController::class, 'edit']);

Route::put('/state/{id}', [StateController::class, 'update']);

Route::delete('/state/{id}', [StateController::class, 'destroy']);