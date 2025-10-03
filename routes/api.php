<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\SkpdController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\PegawaiController;

Route::middleware('api')->group(function () {
    // public auth
    Route::post('/auth/register', [AuthController::class,'register']);
    Route::post('/auth/login',    [AuthController::class,'login']);

    // protected (Bearer token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class,'logout']);

        Route::apiResource('jabatan', JabatanController::class);
        Route::apiResource('skpd', SkpdController::class);
        Route::apiResource('unit-kerja', UnitKerjaController::class);
        Route::apiResource('pegawai', PegawaiController::class);
    });
});
