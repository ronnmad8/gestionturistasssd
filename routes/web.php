<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Adminvisits\AdminvisitsController;
use App\Http\Controllers\Adminreservas\AdminreservasController;
use App\Http\Controllers\Admininicio\AdmininicioController;
use App\Http\Controllers\Auth\LoginController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/logout', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', [AdmininicioController::class, 'index'])->name('inicio');
    
    Route::get('/adminvisits', [AdminvisitsController::class, 'index'])->name('adminvisits');
    Route::post('/adminvisits/updatevisit', [AdminvisitsController::class, 'updatevisit'])->name('adminvisits/updatevisit');
    Route::post('/adminvisits/createvisit', [AdminvisitsController::class, 'createvisit'])->name('adminvisits/createvisit');
    Route::post('/adminvisits/deletevisit', [AdminvisitsController::class, 'deletevisit'])->name('adminvisits/deletevisit');
    Route::post('/adminvisits/setvisithours', [AdminvisitsController::class, 'setvisithours'])->name('adminvisits/setvisithours');
    Route::post('/adminvisits/visitimagesfiles', [AdminvisitsController::class, 'visitimagesfiles'])->name('adminvisits/visitimagesfiles');
    Route::post('/adminvisits/setvisitimages', [AdminvisitsController::class, 'setvisitimages'])->name('adminvisits/setvisitimages');
    
    Route::get('/adminreservas', [AdminreservasController::class, 'index'])->name('adminreservas');
    Route::post('/adminreservas/updatereserva', [AdminreservasController::class, 'updatereserva'])->name('adminreservas/updatereserva');
    Route::post('/adminreservas/setguia', [AdminreservasController::class, 'setguia'])->name('adminreservas/setguia');
    Route::post('/adminreservas/deletereserva', [AdminreservasController::class, 'deletereserva'])->name('adminvisits/deletereserva');
    
    
});