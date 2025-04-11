<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AubController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\AuthController;

// Route untuk guest (tanpa auth)
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');

// Route yang membutuhkan auth
Route::middleware(['auth'])->group(function () {
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
    // Tambahkan route lain yang membutuhkan auth di sini
});

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

Route::group(['prefix' => 'alternatif'], function () {
    Route::get('/', [AlternatifController::class, 'index']);
    Route::get('/create', [AlternatifController::class, 'create']);
    Route::post('/', [AlternatifController::class, 'store']);
    Route::get('/{id}', [AlternatifController::class, 'show']);
    Route::get('/{id}/edit', [AlternatifController::class, 'edit']);
    Route::put('/{id}', [AlternatifController::class, 'update']);
    Route::delete('/{id}', [AlternatifController::class, 'destroy']);
});
