<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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

    Route::get('users/data', [UserController::class, 'data'])->name('users.data');
    Route::put('users/activate/{id}', [UserController::class, 'activate'])->name('users.activate');
    Route::put('users/deactivate/{id}', [UserController::class, 'deactivate'])->name('users.deactivate');
    Route::put('users/roles-update/{id}', [UserController::class, 'roles_user_update'])->name('users.roles_user_update');
    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});
