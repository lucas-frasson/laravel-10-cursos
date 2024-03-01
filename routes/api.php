<?php

use App\Http\Controllers\Api\CursoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::patch('/cursos/{id}', [CursoController::class, 'update']);
Route::get('/cursos/{id}', [CursoController::class, 'show']);
Route::get('/cursos', [CursoController::class, 'index']);
Route::post('/cursos', [CursoController::class, 'store']);

Route::get('/', function () {
    return response()->json([
        'success' => true
    ]);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
