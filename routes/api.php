<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    ///almacenar ordenes
    Route::apiResource('/pedidos', PedidoController::class);

    Route::apiResource('/categorias', CategoriaController::class);
    Route::apiResource('/productos', ProductoController::class);
    Route::post('/pedidos', [PedidoController::class, 'store']);
});




//autenticacion

Route::post('/registro', [ClientController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/clientes', [ClientController::class, 'search']);
