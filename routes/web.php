<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AubController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PlantController;

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'aub'], function () {
    Route::get('/', [AubController::class, 'index']);
    Route::get('/create', [AubController::class, 'create']);
    Route::post('/', [AubController::class, 'store']);
    Route::get('/{id}', [AubController::class, 'show']);
    Route::get('/{id}/edit', [AubController::class, 'edit']);
    Route::put('/{id}', [AubController::class, 'update']);
    Route::delete('/{id}', [AubController::class, 'destroy']);
});

Route::group(['prefix' => 'plant'], function () {
    Route::get('/', [PlantController::class, 'index']);
    Route::get('/create', [PlantController::class, 'create']);
    Route::post('/', [PlantController::class, 'store']);
    Route::get('/{id}', [PlantController::class, 'show']);
    Route::get('/{id}/edit', [PlantController::class, 'edit']);
    Route::put('/{id}', [PlantController::class, 'update']);
    Route::delete('/{id}', [PlantController::class, 'destroy']);
});

Route::group(['prefix' => 'kriteria'], function () {
    Route::get('/', [KriteriaController::class, 'index']);
    Route::get('/create', [KriteriaController::class, 'create']);
    Route::post('/', [KriteriaController::class, 'store']);
    Route::get('/{id}', [KriteriaController::class, 'show']);
    Route::get('/{id}/edit', [KriteriaController::class, 'edit']);
    Route::put('/{id}', [KriteriaController::class, 'update']);
    Route::delete('/{id}', [KriteriaController::class, 'destroy']);
});