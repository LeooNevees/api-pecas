<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\GroupUnitOfMeasureController;
use App\Http\Controllers\ItemGroupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UnitOfMeasurementController;

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

/** Criação de Usuário **/
Route::group([], function () {

    /** API para acesso e manipulação de usuários ... */
    Route::resource('/user', UserController::class);
});

/** Geração de Token **/
Route::group(['middleware' => 'api', 'prefix' => 'jwt'], function($router) {
    // Route::post('/register', [JWTController::class, 'register']);
    Route::post('/generate', [JWTController::class, 'generate']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);
});

/** Sistema **/
Route::group(['middleware' => ['api.jwt']], function () {

    /** Filiais **/
    Route::resource('/branch', BranchController::class);

    /** Depositos **/
    Route::resource('/deposit', DepositController::class);

    /** Estoques **/
    Route::resource('/stock', StockController::class);

    /** Unidade de Medida **/
    Route::resource('/unitOfMeasurement', UnitOfMeasurementController::class);

    /** Grupo Unidade de Medida **/
    Route::resource('/groupUnitOfMeasurement', GroupUnitOfMeasureController::class);

    /** Grupo de Itens **/
    Route::resource('/itemGroup', ItemGroupController::class);

    /** Produtos **/
    Route::resource('/product', ProductController::class);
    
});