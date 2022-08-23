<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('checkpoint', [AuthController::class, 'checkpoint'])->name('checkpoint');

    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('forgot-password', [AuthController::class, 'sendMail'])->name('sendLinkResetPassword');

    Route::get('reset-password/{token}', [AuthController::class, 'editPassword'])->name('editPassword');
    Route::post('update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('', [HomeController::class, 'index'])->name('home');

    Route::name('profile.')->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('edit');
        Route::post('profile', [ProfileController::class, 'update'])->name('update');
    });

    Route::middleware('permission.updateUser')->name('user.')->prefix('user')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        
        Route::middleware('can:updateUser,user')->group(function () {
            Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('update/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('delete/{user}', [UserController::class, 'delete'])->name('delete');
            Route::delete('change-status/{user}', [UserController::class, 'updateStatus'])->name('updateStatus');
        });
    });

    Route::middleware('admin')->name('tag.')->prefix('tag')->group(function () {
        Route::get('', [TagController::class, 'index'])->name('index');
        Route::get('create', [TagController::class, 'create'])->name('create');
        Route::post('store', [TagController::class, 'store'])->name('store');
        Route::get('edit/{tag}', [TagController::class, 'edit'])->name('edit');
        Route::post('update/{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('delete/{tag}', [TagController::class, 'destroy'])->name('delete');
    });
});