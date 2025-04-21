<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Adminvisits\AdminvisitsController;
use App\Http\Controllers\Adminreservas\AdminreservasController;
use App\Http\Controllers\Adminreservasguia\AdminreservasguiaController;
use App\Http\Controllers\Admincitas\AdmincitasController;
use App\Http\Controllers\Admininicio\AdmininicioController;
use App\Http\Controllers\Admininicioguias\AdmininicioguiasController;
use App\Http\Controllers\Adminguia\AdminguiaController;
use App\Http\Controllers\Adminguias\AdminguiasController;
use App\Http\Controllers\Adminclientes\AdminclientesController;
use App\Http\Controllers\Adminfacturacion\AdminfacturacionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Adminhistorics\AdminhistoricsController;

use App\Http\Controllers\Payments\PaymentsController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/logout', function () {
    return redirect('/login');
});

Route::get('/registergu', function () {
    return redirect('/login');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('registergu', [LoginController::class, 'registergu'])->name('registergu');

Route::get('registerpage', function () {
    return view('auth.register');
})->name('registerpage');

Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:3'])->group(function () {
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
        Route::post('/adminreservas/setguiacita', [AdminreservasController::class, 'setguiacita'])->name('adminreservas/setguiacita');
        Route::get('/adminreservas/sorteo', [AdminreservasController::class, 'sorteo'])->name('adminreservas/sorteo');
        Route::post('/adminreservas/deletereserva', [AdminreservasController::class, 'deletereserva'])->name('adminvisits/deletereserva');
        
        Route::get('/admincitas', [AdmincitasController::class, 'index'])->name('admincitas');
        Route::post('/admincitas/cita', [AdmincitasController::class, 'getcita'])->name('admincitas/cita');
        Route::post('/admincitas/setstatus', [AdmincitasController::class, 'setstatus'])->name('admincitas/setstatus');
        Route::post('/admincitas/setguia', [AdmincitasController::class, 'setguia'])->name('admincitas/setguia');
    
        Route::get('/adminguias', [AdminguiasController::class, 'index'])->name('adminguias');
        Route::post('/adminguias/guia', [AdminguiasController::class, 'setguia'])->name('adminguias/guia');
        Route::post('/adminguias/deleteguia', [AdminguiasController::class, 'deleteguia'])->name('adminguias/deleteguia');
        
        Route::get('/adminclientes', [AdminclientesController::class, 'index'])->name('adminclientes');
        Route::post('/adminclientes/cliente', [AdminclientesController::class, 'setcliente'])->name('adminclientes/cliente');
        Route::post('/adminclientes/deletecliente', [AdminclientesController::class, 'deletecliente'])->name('adminclientes/deletecliente');
    
        Route::get('/adminfacturacion', [AdminfacturacionController::class, 'index'])->name('adminfacturacion');
        Route::get('/excelfacturacion/{mes}', [AdminFacturacionController::class, 'excelfacturacion'])->name('excelfacturacion');
    
        Route::get('/adminhistorics', [AdminhistoricsController::class, 'index'])->name('adminhistorics');
    });


    Route::middleware(['role:2,4'])->group(function () {

        Route::get('/inicioguias', [AdmininicioguiasController::class, 'index'])->name('inicioguias');
        Route::get('/adminreservasguia', [AdminreservasguiaController::class, 'index'])->name('adminreservasguia');
        Route::post('/adminreservasguia/rechazarreserva', [AdminreservasguiaController::class, 'rechazarreserva'])->name('adminreservasguia/rechazarreserva');
        Route::post('/admincitasguia/rechazarcita', [AdminreservasguiaController::class, 'rechazarcita'])->name('admincitasguia/rechazarcita');
        Route::get('/adminguia/{id}', [AdminGuiaController::class, 'index'])->name('adminguia');
        Route::post('/adminguia/setguia/{id}', [AdminGuiaController::class, 'setguia'])->name('adminguia/setguia');

    });


    

});


Route::post('/payments_callback', [PaymentsController::class, 'callback'])->name('payments_callback');
Route::get('/payments_success', [PaymentsController::class, 'success'])->name('payments_success');
Route::get('/payments_failure', [PaymentsController::class, 'failure'])->name('payments_failure');