<?php
use App\Http\Controllers\PincodeController;
use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
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

Route::get('/country', [CountryController::class, 'index']);

Route::post('/country/store', [CountryController::class, 'store']);

Route::get('/country/edit/{id}', [CountryController::class, 'edit']);

Route::post('/country/update/{id}', [CountryController::class, 'update']);

Route::delete('/country/delete/{id}', [CountryController::class, 'destroy']);
=======


// Route::get('/', function () {
//     return view('welcome');
// });


    Route::get('/pincodes', [PincodeController::class, 'index'])->name('pincodes.index');

    Route::get('/pincodes/datatable', [PincodeController::class, 'datatable'])->name('pincodes.datatable');

    Route::post('/pincodes/store', [PincodeController::class, 'store'])->name('pincodes.store');

    Route::get('/pincodes/edit/{id}', [PincodeController::class, 'edit'])->name('pincodes.edit');

    Route::post('/pincodes/update/{id}', [PincodeController::class, 'update'])->name('pincodes.update');

    Route::delete('/pincodes/delete/{id}', [PincodeController::class, 'destroy'])->name('pincodes.delete');

    Route::get('/states/{country}', [PincodeController::class, 'getStates']);

    Route::get('/cities/{state}', [PincodeController::class, 'getCities']);
    Route::get('/state', [StateController::class, 'index']);

Route::post('/state', [StateController::class, 'store']);

Route::get('/state/list', [StateController::class, 'list']);

Route::get('/state/{id}/edit', [StateController::class, 'edit']);

Route::put('/state/{id}', [StateController::class, 'update']);

Route::delete('/state/{id}', [StateController::class, 'destroy']);
>>>>>>> Stashed changes