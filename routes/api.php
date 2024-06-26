<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CursoController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rota de login
Route::post('/login', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Rota de cursos
Route::middleware(['auth:sanctum'])->group(function (){
    // CRUD Cursos
    // Route::apiResource('/cursos', CursoController::class);
    Route::post('/cursos/index', [CursoController::class, 'index']);
    Route::post('/cursos', [CursoController::class, 'store']); 
    Route::get('/cursos/{id}', [CursoController::class, 'show']);
    Route::patch('/cursos/{id}', [CursoController::class, 'update']);
    Route::delete('/cursos/{id}', [CursoController::class, 'destroy']);
    Route::get('/delete_curso/{id}', [CursoController::class, 'delete_curso']);

    // CRUD Usuarios
    Route::post('/index_usuarios', [UserController::class, 'index_usuarios']);
    Route::post('/usuarios', [UserController::class,'store_usuario']); 
    Route::get('/usuarios/{id}', [UserController::class,'show_usuario']);
    Route::post('/update_usuario/{id}', [UserController::class, 'update_usuario']);
    Route::post('/destroy_usuario/{id}', [UserController::class, 'destroy_usuario']);
    Route::post('/delete_usuario/{id}', [UserController::class, 'delete_usuario']);

    // Admin
    Route::post('/verifica_admin', [UserController::class, 'verifica_admin']);
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
