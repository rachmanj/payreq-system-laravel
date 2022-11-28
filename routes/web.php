<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdvanceCategoryController;
use App\Http\Controllers\ApprovedController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\DashboardAccountingController;
use App\Http\Controllers\DashboardDncController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OutgoingController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RabController;
use App\Http\Controllers\RealizationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
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

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardUserController::class, 'index'])->name('index');
        Route::get('/{id}', [DashboardUserController::class, 'show'])->name('show');
    });

    Route::prefix('approved')->name('approved.')->group(function () {
        Route::get('/data', [ApprovedController::class, 'data'])->name('data');
        Route::get('/all', [ApprovedController::class, 'all'])->name('all');
        Route::get('/all/data', [ApprovedController::class, 'all_data'])->name('all.data');
    });
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

    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/', [SearchController::class, 'index'])->name('index');
        Route::post('/display', [SearchController::class, 'display'])->name('display');
        Route::get('/{id}/edit', [SearchController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SearchController::class, 'update'])->name('update');
        Route::delete('/{id}', [SearchController::class, 'destroy'])->name('destroy');
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

    Route::prefix('rekaps')->name('rekaps.')->group(function () {
        Route::get('/data', [RekapController::class, 'data'])->name('data');
        Route::get('/', [RekapController::class, 'index'])->name('index');
        Route::delete('/{id}', [RekapController::class, 'destroy'])->name('destroy');
        Route::get('/export', [RekapController::class, 'export'])->name('export');
    });

    Route::prefix('budget')->name('budget.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::get('/just_updated', [BudgetController::class, 'just_updated'])->name('just_updated');
        Route::put('/{id}', [BudgetController::class, 'update'])->name('update');
        Route::get('/data', [BudgetController::class, 'data'])->name('data');
        Route::get('/just_updated/data', [BudgetController::class, 'just_updated_data'])->name('just_updated_data');
    });

    Route::get('adv-category/data', [AdvanceCategoryController::class, 'data'])->name('adv-category.data');
    Route::resource('adv-category', AdvanceCategoryController::class);

    Route::prefix('acc-dashboard')->name('acc-dashboard.')->group(function () {
        Route::get('/', [DashboardAccountingController::class, 'index'])->name('index');
        Route::get('test', [DashboardAccountingController::class, 'test'])->name('test');
    });

    Route::prefix('dnc-dashboard')->name('dnc-dashboard.')->group(function () {
        Route::get('/', [DashboardDncController::class, 'index'])->name('index');
        Route::get('test', [DashboardDncController::class, 'test'])->name('test');
    });
});

Route::get('/kirimemail', [EmailController::class, 'index']);
