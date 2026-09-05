<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SessionController;
use App\Http\Controllers\Api\TypeMasterController;
use App\Http\Controllers\Api\GrilleEvaluationController;
use App\Http\Controllers\Api\CritereController;
use App\Http\Controllers\Api\BaremeController;
use App\Http\Controllers\Api\CoefficientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('sessions', SessionController::class);
Route::apiResource('type-masters', TypeMasterController::class);
Route::apiResource('grilles-evaluation', GrilleEvaluationController::class)
    ->parameters([
        'grilles-evaluation' => 'grilleEvaluation'
    ]);
Route::apiResource('criteres', CritereController::class);
Route::apiResource('baremes', BaremeController::class);
Route::apiResource('coefficients', CoefficientController::class);