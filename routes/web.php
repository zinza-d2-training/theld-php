<?php

use App\Http\Controllers\AuthController;
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

Route::middleware(['auth'])->get('logout', [AuthController::class, 'logout'])->name('logout');

