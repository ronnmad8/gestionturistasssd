<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Adminvisits\AdminvisitsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('welcome');
});

Route::get('/inicio', [AdminvisitsController::class, 'inicio'])->name('inicio');

///Route::get('/adminvisits', [AdminvisitsController::class, 'index'])->name('adminvisits')->middleware('auth');
Route::get('/adminvisits', [AdminvisitsController::class, 'index'])->name('adminvisits');
Route::get('/adminvisits/updatevisit', [AdminvisitsController::class, 'updatevisit'])->name('adminvisits/updatevisit');
Route::get('/adminvisits/createvisit', [AdminvisitsController::class, 'createvisit'])->name('adminvisits/createvisit');