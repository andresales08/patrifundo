<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatrimonioController;
/*...*/

Route::get('/', [PatrimonioController::class, 'index']);
Route::get('/dashboard', [PatrimonioController::class, 'index']);
Route::get('/patrimonio', [PatrimonioController::class, 'patrimonio']);
Route::get('/patrimonio/edit/{id}', [PatrimonioController::class, 'edit']);

Route::resource('patrimonios', PatrimonioController::class);

