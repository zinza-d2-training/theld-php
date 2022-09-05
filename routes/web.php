<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\commentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
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

// GUEST
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

    // Dashboard
    Route::get('', [DashboardController::class, 'index'])->name('home');
    Route::get('t/{slug}', [DashboardController::class, 'topicDetail'])->name('topicDetail');
    Route::get('s', [DashboardController::class, 'search'])->name('search');
    Route::get('p/{slug}', [DashboardController::class, 'postDetail'])->name('postDetail');

    // Profile
    Route::name('profile.')->group(function () {
        Route::get('profile', 'ProfileController@edit')->name('edit');
        Route::post('profile', [ProfileController::class, 'update'])->name('update');
    });

    // User
    Route::middleware('permission.updateUser')->name('user.')->prefix('user')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        
        Route::middleware('can:updateUser,user')->group(function () {
            Route::get('edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('update/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('delete/{user}', [UserController::class, 'delete'])->name('delete');
            Route::delete('delete-multiple/{user[]}', [UserController::class, 'deleteMultiple'])->name('deleteMultiple');
            Route::delete('change-status/{user}', [UserController::class, 'updateStatus'])->name('updateStatus');
        });
    });
    
    // Company
    Route::middleware('admin')->name('company.')->prefix('company')->group(function () {
        Route::get('', [CompanyController::class, 'index'])->name('index');
        Route::get('create', [CompanyController::class, 'create'])->name('create');
        Route::post('store', [CompanyController::class, 'store'])->name('store');
        Route::get('edit/{company}', [CompanyController::class, 'edit'])->name('edit');
        Route::post('update/{company}', [CompanyController::class, 'update'])->name('update');
        Route::delete('delete/{company}', [CompanyController::class, 'destroy'])->name('delete');
        Route::get('change-status/{company}', [CompanyController::class, 'updateStatus'])->name('updateStatus');
    });

    // Topic
    Route::middleware('admin')->name('topic.')->prefix('topic')->group(function () {
        Route::get('', [TopicController::class, 'index'])->name('index');
        Route::get('create', [TopicController::class, 'create'])->name('create');
        Route::post('store', [TopicController::class, 'store'])->name('store');
        Route::get('edit/{topic}', [TopicController::class, 'edit'])->name('edit');
        Route::post('update/{topic}', [TopicController::class, 'update'])->name('update');
        Route::delete('delete/{topic}', [TopicController::class, 'destroy'])->name('delete');
        Route::delete('change-status/{topic}', [TopicController::class, 'updateStatus'])->name('updateStatus');
    });
    
    // Tag
    Route::middleware('admin')->name('tag.')->prefix('tag')->group(function () {
        Route::get('', [TagController::class, 'index'])->name('index');
        Route::get('create', [TagController::class, 'create'])->name('create');
        Route::post('store', [TagController::class, 'store'])->name('store');
        Route::get('edit/{tag}', [TagController::class, 'edit'])->name('edit');
        Route::post('update/{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('delete/{tag}', [TagController::class, 'destroy'])->name('delete');
    });

    // Post
    Route::name('post.')->prefix('post')->group(function () {
        Route::get('', [PostController::class, 'index'])->name('index');
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::middleware('can:updatePost,post')->group(function () {
            Route::get('edit/{post}', [PostController::class, 'edit'])->name('edit');
            Route::post('update/{post}', [PostController::class, 'update'])->name('update');
            Route::delete('delete/{post}', [PostController::class, 'destroy'])->name('delete');
        });
        Route::put('pin/{post}', [PostController::class, 'pin'])->middleware('admin')->name('pin');
    });

    // Comment
    Route::name('comment.')->prefix('comment')->group(function () {
        Route::post('store/{post}', [commentController::class, 'store'])->name('store');
        Route::get('reaction/{id}', [commentController::class, 'reaction'])->name('reaction');
        Route::get('resolved/{comment}', [commentController::class, 'resolved'])->name('resolved');
        Route::middleware('can:updatePost,post')->group(function () {
            Route::post('update/{post}', [commentController::class, 'update'])->name('update');
            Route::delete('delete/{post}', [commentController::class, 'destroy'])->name('delete');
        });
    });
});