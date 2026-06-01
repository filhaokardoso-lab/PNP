<?php

use App\Http\Controllers\API\apiController;
use App\Http\Controllers\Api\ComentarioApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/user', [apiController::class, 'index']);

// Rotas públicas de API para comentários
Route::prefix('comentarios')->group(function () {
    Route::get('/', [ComentarioApiController::class, 'index']);
    Route::get('/{comentario}', [ComentarioApiController::class, 'show']);
    Route::get('/categoria/{categoria}', [ComentarioApiController::class, 'porCategoria']);
    Route::get('/stats', [ComentarioApiController::class, 'estatisticas']);
    Route::get('/recentes/{limit?}', [ComentarioApiController::class, 'recentes']);
    Route::post('/', [ComentarioApiController::class, 'store']);
    Route::delete('/{comentario}', [ComentarioApiController::class, 'destroy']);
});
