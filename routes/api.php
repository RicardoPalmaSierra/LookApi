<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthTokenValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication
Route::post('login', [UserController::class, 'logIn']);
Route::post('register', [UserController::class, 'register']);


// Profesionales
Route::post('search', [ProfessionalController::class, 'search']);
Route::get('professional/{id}', [ProfessionalController::class, 'getProfessionalById']);
Route::get('profile', [UserController::class, 'profile'])->middleware('token');


// Configuraciones
Route::get('countries', [ConfigController::class, 'countries']);
Route::get('cities/{country}', [ConfigController::class, 'cities']);

//Usuarios
Route::post('update/user', [UserController::class, 'update'])->middleware('token');
