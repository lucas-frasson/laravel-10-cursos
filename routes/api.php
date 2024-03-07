<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CursoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rota de login
Route::post('/login', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('/cursos', CursoController::class);

// Rota de cursos
Route::middleware(['auth:sanctum'])->group(function (){
    // Route::apiResource('/cursos', CursoController::class);
    // Route::delete('/cursos/{id}', [CursoController::class, 'destroy']);
    // Route::patch('/cursos/{id}', [CursoController::class, 'update']);
    // Route::get('/cursos/{id}', [CursoController::class, 'show']);
    // Route::get('/cursos', [CursoController::class, 'index']);
    // Route::post('/cursos', [CursoController::class, 'store']); 
});

// Rota de teste
Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
