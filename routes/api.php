<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

use App\Http\Controllers\Test\TestController;
use App\Http\Controllers\Contacto\ContactoController;
use App\Http\Controllers\Basex\BasexController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Tags\TagsController;
use App\Http\Controllers\Mediafiles\MediafilesController;
use App\Http\Controllers\Hours\HoursController;
use App\Http\Controllers\Languages\LanguagesController;
use App\Http\Controllers\Isolanguages\IsolanguagesController;

use App\Http\Controllers\Visit\VisitController;
use App\Http\Controllers\Visit\VisitCategoryController;
use App\Http\Controllers\Visittags\VisittagsController ;
use App\Http\Controllers\Visithours\VisithoursController ;
use App\Http\Controllers\Pedido\PedidoController;
use App\Http\Controllers\VisitFilt\VisitFiltController;
use App\Http\Controllers\Reserva\ReservaController;
use App\Http\Controllers\Textcontents\TextcontentsController;
use App\Http\Controllers\Textcomments\TextcommentsController;

/** @var \Laravel\Lumen\Routing\Router $router */

/**
 * Test
 */
Route::get('/test', function() {
    return "test api ok";
});

/**
 * Basex
 */
Route::resource('basex', BasexController::class, ['only' => ['index', 'show']]);
Route::resource('testcontrol', TestController::class, ['only' => ['show']]);


/**
 * Textcontents
 */
Route::get('/textcontents/{id}', [TextcontentsController::class, 'index']);

/**
 * Textcomments
 */
Route::get('/textcomments/{id}', [TextcommentsController::class, 'index']);

/**
 * Mediafiles
 */
Route::resource('mediafiles', MediafilesController::class, ['only' => ['index']]);

/**
 * Visit
 */
//Route::resource('visits', VisitController::class, ['only' => ['index','show','store','update','destroy']]);
//Route::resource('visits.reservas', VisitReservaController::class, ['only' => ['index']]);
Route::get('/visitrecommended/{id}', [VisitController::class, 'recommended']);
Route::get('/visitdetail/{id}/{langid}', [VisitController::class, 'visitdetail']);

/**
 * VisitFilt
 */
//Route::resource('visitfilt', VisitFiltController::class, ['only' => ['index']]);

Route::post('/visitsearch', [VisitFiltController::class, 'search']);
Route::post('/visitsearchbasic', [VisitController::class, 'searchbasic']);
Route::get('/hoursid', [VisitFiltController::class, 'hoursid']);

/**
 * Reserva
 */
Route::resource('reservas', ReservaController::class, ['only' => ['index', 'show','store','update','destroy']]);

Route::get('/reserva/{id}', [ReservaController::class, 'reserva']);


/**
 * Categories
 */
//Route::resource('categories', CategoryController::class, ['only' => ['index','show','store','update', 'destroy']]);
Route::resource('categories', CategoryController::class, ['only' => ['index']]);
Route::get('/categoriestext/{id}', [CategoryController::class, 'categories']);

/**
 * Tags
 */
//Route::resource('tags', TagsController::class, ['only' => ['index', 'show','store','update','destroy']]);
Route::resource('tags', TagsController::class, ['only' => ['index']]);

/**
 * Hours
 */
Route::resource('hours', HoursController::class, ['only' => ['index']]);

/**
 * Languages
 */
Route::resource('languages', LanguagesController::class, ['only' => ['index']]);

/**
 * isolanguages
 */
Route::resource('isolanguages', IsolanguagesController::class, ['only' => ['index']]);
Route::get('/isolanguages/{id}', [IsolanguagesController::class, 'isolanguages']);


/**
 * Visittag
 */
//Route::resource('visittags', VisittagsController::class, ['only' => ['store','destroy']]);

/**
 * Contacto
 */
//Route::resource('contactos', ContactoController::class, ['only' => ['show','store','update','destroy']]);

/**
 * Login
 */
Route::post('login', [LoginController::class, 'issueToken']);


/**
 * Users
 */
Route::post('register', [UserController::class, 'store']);
Route::resource('users', UserController::class, ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
Route::get('/me', [UserController::class, 'me']);
Route::get('/reservascliente/{idlang}/{idpedido}', [UserController::class, 'reservascliente']);
Route::get('/pedidocliente/{idpedido}', [PedidoController::class, 'pedido']);
Route::post('/pedidocliente', [PedidoController::class, 'store']);


Route::resource('users/verify/{token}', UserController::class, ['only' =>['verify']]);
//Route::resource('users/{user}/resend', UserController::class, ['only' =>['resend']]);

