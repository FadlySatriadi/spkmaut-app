<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AubController;
use App\Http\Controllers\OAubController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\OKriteriaController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\OPlantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\ORekomendasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\UserController;

Route::middleware(['cek_login:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['cek_login:officer'])->prefix('officer')->group(function () {
    Route::get('/dashboard', [OfficerController::class, 'dashboard'])->name('officer.dashboard');
});

// Auth routes
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
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

Route::group(['prefix' => 'officeraub'], function () {
    Route::get('/', [OAubController::class, 'index']);
    Route::post('/', [OAubController::class, 'store']);
    Route::get('/{id}', [OAubController::class, 'show']);
    Route::delete('/{id}', [OAubController::class, 'destroy']);
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

Route::group(['prefix' => 'oplant'], function () {
    Route::get('/', [OPlantController::class, 'index']);
    Route::post('/', [OPlantController::class, 'store']);
    Route::get('/{id}', [OPlantController::class, 'show']);
    Route::delete('/{id}', [OPlantController::class, 'destroy']);
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

Route::group(['prefix' => 'okriteria'], function () {
    Route::get('/', [OKriteriaController::class, 'index']);
    Route::post('/', [OKriteriaController::class, 'store']);
    Route::get('/{id}', [OKriteriaController::class, 'show']);
    Route::delete('/{id}', [OKriteriaController::class, 'destroy']);
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('rekomendasi')->group(function () {
        Route::get('/select-plants', [RekomendasiController::class, 'selectPlants'])->name('rekomendasi.select-plants');
        Route::post('/store-plants', [RekomendasiController::class, 'storePlants'])->name('rekomendasi.store-plants');
        Route::get('/input-nilai', [RekomendasiController::class, 'inputNilai'])->name('rekomendasi.input-nilai');
        Route::post('/calculate', [RekomendasiController::class, 'calculate'])->name('rekomendasi.calculate');
        Route::get('/detail', [RekomendasiController::class, 'showDetail'])->name('rekomendasi.detail');
        Route::post('/save-recommendation', [RekomendasiController::class, 'saveRecommendation'])->name('rekomendasi.save');
    });

    // Route history
    Route::post('/recommendation/save-cache', [RekomendasiController::class, 'saveToCache'])
        ->name('rekomendasi.save-cache');
    Route::get('/rekomendasi/cetak', [RekomendasiController::class, 'cetakpdf'])
        ->name('rekomendasi.cetak')
        ->middleware('auth');

    Route::get('/recommendation/cache-history', [RekomendasiController::class, 'showCacheHistory'])
        ->name('rekomendasi.cache-history');
    Route::get('/rekomendasi/history/{timestamp}/print', [RekomendasiController::class, 'printHistory'])->name('rekomendasi.print-history');
    Route::get('/recommendation/cache-history/{timestamp}', [RekomendasiController::class, 'showCacheHistoryDetail'])
        ->name('rekomendasi.cache-history.detail');
    Route::delete('/recommendation/cache-history/{timestamp}', [RekomendasiController::class, 'deleteHistory'])
        ->name('rekomendasi.cache-history.delete');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('o/rekomendasi')->group(function () {
        Route::get('/select-plants', [ORekomendasiController::class, 'selectPlants'])->name('officer.rekomendasi.select-plants');
        Route::post('/store-plants', [ORekomendasiController::class, 'storePlants'])->name('officer.rekomendasi.store-plants');
        Route::get('/input-nilai', [ORekomendasiController::class, 'inputNilai'])->name('officer.rekomendasi.input-nilai');
        Route::post('/calculate', [ORekomendasiController::class, 'calculate'])->name('officer.rekomendasi.calculate');
        Route::get('/detail', [ORekomendasiController::class, 'showDetail'])->name('officer.rekomendasi.detail');
        Route::post('/save-recommendation', [ORekomendasiController::class, 'saveRecommendation'])->name('officer.rekomendasi.save');
    });

    // Route history
    Route::post('o/recommendation/save-cache', [ORekomendasiController::class, 'saveToCache'])
        ->name('officer.rekomendasi.save-cache');
    Route::get('o/rekomendasi/cetak', [ORekomendasiController::class, 'cetakpdf'])
        ->name('officer.rekomendasi.cetak')
        ->middleware('auth');

    Route::get('o/recommendation/cache-history', [ORekomendasiController::class, 'showCacheHistory'])
        ->name('officer.rekomendasi.cache-history');
    Route::get('o/rekomendasi/history/{timestamp}/print', [ORekomendasiController::class, 'printHistory'])->name('officer.rekomendasi.print-history');
    Route::get('o/recommendation/cache-history/{timestamp}', [ORekomendasiController::class, 'showCacheHistoryDetail'])
        ->name('officer.rekomendasi.cache-history.detail');
    Route::delete('o/recommendation/cache-history/{timestamp}', [ORekomendasiController::class, 'deleteHistory'])
        ->name('officer.rekomendasi.cache-history.delete');
});
