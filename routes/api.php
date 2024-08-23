<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangHistoryController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::name('barang.')->prefix('barang')->group(function () {
//     Route::get('/', [BarangController::class, 'index'])->name('index');
//     Route::get('/{id}', [BarangController::class, 'show'])->name('show');
//     Route::post('/', [BarangController::class, 'store'])->name('store');
//     Route::put('/{id}', [BarangController::class, 'update'])->name('update');
//     Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
// });



// Route::get('/users', [UserController::class, 'index']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('user', [AuthController::class, 'user'])->middleware('auth:api');



Route::middleware('auth:api')->group(function () {
    Route::name('barang.')->prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('/{id}', [BarangController::class, 'show'])->name('show');
        Route::post('/', [BarangController::class, 'store'])->name('store');
        Route::put('/{id}', [BarangController::class, 'update'])->name('update');
        Route::delete('/{id}', [BarangController::class, 'destroy'])->name('destroy');
    });

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);


    Route::name('mutasi.')->prefix('mutasi')->group(function () {
        Route::get('/', [MutasiController::class, 'index'])->name('index');
        Route::get('/{id}', [MutasiController::class, 'show'])->name('show');
        Route::post('/', [MutasiController::class, 'store'])->name('store');
        Route::put('/{id}', [MutasiController::class, 'update'])->name('update');
        Route::delete('/{id}', [MutasiController::class, 'destroy'])->name('destroy');
        Route::get('/user/{userId}', [MutasiController::class, 'getMutasiHistoryByUserId']);
        Route::get('/barang/{barangId}', [MutasiController::class, 'getMutasiHistoryByBarangId']);
    });
});
