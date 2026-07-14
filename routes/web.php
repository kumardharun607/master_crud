<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PincodeController;

// Home
Route::get('/', function () {
    return redirect('/country');
});

/*
|--------------------------------------------------------------------------
| Country CRUD
|--------------------------------------------------------------------------
*/

Route::get('/country', [CountryController::class, 'index'])->name('country.index');

Route::post('/country/store', [CountryController::class, 'store'])->name('country.store');

Route::get('/country/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');

Route::post('/country/update/{id}', [CountryController::class, 'update'])->name('country.update');

Route::delete('/country/delete/{id}', [CountryController::class, 'destroy'])->name('country.delete');


/*
|--------------------------------------------------------------------------
| Pincode CRUD
|--------------------------------------------------------------------------
*/

Route::get('/pincodes', [PincodeController::class, 'index'])->name('pincodes.index');

Route::get('/pincodes/datatable', [PincodeController::class, 'datatable'])->name('pincodes.datatable');

Route::post('/pincodes/store', [PincodeController::class, 'store'])->name('pincodes.store');

Route::get('/pincodes/edit/{id}', [PincodeController::class, 'edit'])->name('pincodes.edit');

Route::post('/pincodes/update/{id}', [PincodeController::class, 'update'])->name('pincodes.update');

Route::delete('/pincodes/delete/{id}', [PincodeController::class, 'destroy'])->name('pincodes.delete');

Route::get('/states/{country}', [PincodeController::class, 'getStates']);

Route::get('/cities/{state}', [PincodeController::class, 'getCities']);