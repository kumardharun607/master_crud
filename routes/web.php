<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

// Redirect Home
Route::get('/', function () {
    return redirect('/country');
});

// Country CRUD
Route::get('/country', [CountryController::class, 'index']);

Route::post('/country/store', [CountryController::class, 'store']);

Route::get('/country/edit/{id}', [CountryController::class, 'edit']);

Route::post('/country/update/{id}', [CountryController::class, 'update']);

Route::delete('/country/delete/{id}', [CountryController::class, 'destroy']);