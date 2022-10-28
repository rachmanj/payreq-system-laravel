<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApprovedController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RabController;
use App\Http\Controllers\RealizationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('templates.dashboard');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('data', [UserController::class, 'data'])->name('data');
        Route::put('activate/{id}', [UserController::class, 'activate'])->name('activate');
        Route::put('deactivate/{id}', [UserController::class, 'deactivate'])->name('deactivate');
        Route::put('roles-update/{id}', [UserController::class, 'roles_user_update'])->name('roles_user_update');
    });

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('approved/data', [ApprovedController::class, 'data'])->name('approved.data');
    Route::resource('approved', ApprovedController::class);

    Route::prefix('realization')->name('realization.')->group(function () {
        Route::get('/data', [RealizationController::class, 'data'])->name('data');
        Route::get('/', [RealizationController::class, 'index'])->name('index');
        Route::put('/{id}', [RealizationController::class, 'update'])->name('update');
    });

    Route::prefix('outgoing')->name('outgoing.')->group(function () {
        Route::get('/data', [OutgoingController::class, 'data'])->name('data');
        Route::get('/', [OutgoingController::class, 'index'])->name('index');
        Route::put('/{id}', [OutgoingController::class, 'update'])->name('update');
        Route::get('/{id}/split', [OutgoingController::class, 'split'])->name('split');
        Route::put('/{id}/update-split', [OutgoingController::class, 'split_update'])->name('split_update');
        Route::put('/{id}/auto', [OutgoingController::class, 'auto_update'])->name('auto_update');
    });

    Route::prefix('verify')->name('verify.')->group(function () {
        Route::get('/data', [VerifyController::class, 'data'])->name('data');
        Route::get('/', [VerifyController::class, 'index'])->name('index');
        Route::put('/{id}', [VerifyController::class, 'update'])->name('update');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/report1', [ReportController::class, 'report1_index'])->name('report1.index');
        Route::get('/report1/{id}/edit', [ReportController::class, 'report1_edit'])->name('report1.edit');
        Route::put('/report1/{id}', [ReportController::class, 'report1_update'])->name('report1.update');
        Route::delete('/report1/{id}', [ReportController::class, 'report1_destroy'])->name('report1.destroy');
        Route::post('/report1/display', [ReportController::class, 'report1_display'])->name('report1.display');
    });

    Route::prefix('rabs')->name('rabs.')->group(function () {
        Route::get('/data', [RabController::class, 'data'])->name('data');
        Route::get('/{rab_id}/data', [RabController::class, 'payreq_data'])->name('payreq_data');
    });
    Route::resource('rabs', RabController::class);

    Route::get('transaksi/data', [TransaksiController::class, 'data'])->name('transaksi.data');
    Route::resource('transaksi', TransaksiController::class);

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/data', [AccountController::class, 'data'])->name('data');
        Route::post('/transaksi-store', [AccountController::class, 'transaksi_store'])->name('transaksi_store');
    });
    Route::resource('account', AccountController::class);
});
