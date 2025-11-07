<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas de Cursos
Route::prefix('cursos')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\CursoController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\CursoController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\Api\CursoController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\Api\CursoController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\CursoController::class, 'destroy']);
});

// Rotas de Disciplinas
Route::prefix('disciplinas')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\DisciplinaController::class, 'index']);
    Route::get('/curso/{cursoId}', [App\Http\Controllers\Api\DisciplinaController::class, 'porCurso']);
    Route::post('/', [App\Http\Controllers\Api\DisciplinaController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\Api\DisciplinaController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\Api\DisciplinaController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\DisciplinaController::class, 'destroy']);
});

// Rotas de Alunos
Route::prefix('alunos')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\AlunoController::class, 'index']);
    Route::get('/curso/{cursoId}', [App\Http\Controllers\Api\AlunoController::class, 'porCurso']);
    Route::get('/cpf/{cpf}', [App\Http\Controllers\Api\AlunoController::class, 'porCpf']);
    Route::post('/', [App\Http\Controllers\Api\AlunoController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\Api\AlunoController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\Api\AlunoController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\AlunoController::class, 'destroy']);
    Route::post('/{id}/cursos', [App\Http\Controllers\Api\AlunoController::class, 'vincularCursos']);
});

// Rotas de Matrículas
Route::prefix('matriculas')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\MatriculaController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\MatriculaController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\Api\MatriculaController::class, 'show']);
    Route::put('/{id}/trancar', [App\Http\Controllers\Api\MatriculaController::class, 'trancar']);
});

