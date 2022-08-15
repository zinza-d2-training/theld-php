<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
Route::middleware(['auth'])->name('auth.logout')->get('logout', [AuthController::class, 'logout']);

Route::middleware('auth')->name('profile.')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('update');
});

Route::middleware('auth')->group(function () {
    Route::get('', [HomeController::class, 'index'])->name('home');
});



