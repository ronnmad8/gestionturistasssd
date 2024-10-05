<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Adminvisits\AdminvisitsController;


Route::middleware(['web'])->group(function () {

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('welcome');
});

Route::get('/inicio', [AdminvisitsController::class, 'inicio'])->name('inicio');

///Route::get('/adminvisits', [AdminvisitsController::class, 'index'])->name('adminvisits')->middleware('auth');
Route::get('/adminvisits', [AdminvisitsController::class, 'index'])->name('adminvisits');
Route::post('/adminvisits/updatevisit', [AdminvisitsController::class, 'updatevisit'])->name('adminvisits/updatevisit');
Route::post('/adminvisits/createvisit', [AdminvisitsController::class, 'createvisit'])->name('adminvisits/createvisit');
Route::post('/adminvisits/deletevisit', [AdminvisitsController::class, 'deletevisit'])->name('adminvisits/deletevisit');
Route::post('/adminvisits/setvisithours', [AdminvisitsController::class, 'setvisithours'])->name('adminvisits/setvisithours');
Route::post('/adminvisits/setvisitimages', [AdminvisitsController::class, 'setvisitimages'])->name('adminvisits/setvisitimages');



});