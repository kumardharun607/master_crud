<?php


use App\Http\Controllers\PincodeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;

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
| State CRUD
|--------------------------------------------------------------------------
*/

Route::get('/state', [StateController::class, 'index'])->name('state.index');

    Route::get('/cities/{state}', [PincodeController::class, 'getCities']);

    Route::post('/state', [StateController::class, 'store'])->name('state.store');

Route::get('/state/list', [StateController::class, 'list'])->name('state.list');

Route::get('/state/{id}/edit', [StateController::class, 'edit'])->name('state.edit');

Route::put('/state/{id}', [StateController::class, 'update'])->name('state.update');

Route::delete('/state/{id}', [StateController::class, 'destroy'])->name('state.destroy');

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

/*
|--------------------------------------------------------------------------
| Dropdown APIs
|--------------------------------------------------------------------------
*/

Route::get('/states/{country}', [PincodeController::class, 'getStates']);

Route::get('/cities/{state}', [PincodeController::class, 'getCities']);

Route::get('/city', [CityController::class, 'index']);

Route::get('/city/list', [CityController::class, 'list']);

Route::post('/city', [CityController::class, 'store']);

Route::get('/city/{id}/edit', [CityController::class, 'edit']);

Route::put('/city/{id}', [CityController::class, 'update']);

Route::delete('/city/{id}', [CityController::class, 'destroy']);

Route::get('/states-by-country/{countryId}', [CityController::class, 'getStates']);

