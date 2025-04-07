<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AubController;

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'aub'], function () {
    Route::get('/', [AubController::class, 'index']);
    Route::post('/list', [AubController::class, 'list']);
    Route::get('/create', [AubController::class, 'create']);
    Route::post('/', [AubController::class, 'store']);
    Route::get('/{id}', [AubController::class, 'show']);
    Route::get('/{id}/edit', [AubController::class, 'edit']);
    Route::put('/{id}', [AubController::class, 'update']);
    Route::delete('/{id}', [AubController::class, 'destroy']);
});