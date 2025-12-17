<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userViewController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [UserViewController::class, 'showLogin'])->name('login');
Route::post('/login', [UserViewController::class, 'login']);
Route::post('/logout', [UserViewController::class, 'logout'])->name('logout');

Route::middleware('jwt.session')->group(function () {
    Route::middleware('jwt.session')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::get('/pendapatan', [PendapatanController::class, 'index'])->name('pendapatan');
        // Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
        // Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/akun', [AkunController::class, 'index'])->name('akun');

        Route::get('/akun/tambah', [AkunController::class, 'create']);
        Route::post('/akun', [AkunController::class, 'store']);

        Route::get('/akun/{id}/edit', [AkunController::class, 'edit']);
        Route::put('/akun/{id}', [AkunController::class, 'update']);

        Route::delete('/akun/{id}', [AkunController::class, 'destroy']);
    });
});
