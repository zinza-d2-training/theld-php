<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
    return response()->json([
        'data' => $request->user(),
    ], 200);
});


//GUEST
Route::prefix('auth')->group(function () {
    Route::post('login', 'AuthController@checkpoint');
    Route::post('send-mail-reset-password', 'AuthController@sendMail');
    Route::post('valid-reset-token', 'AuthController@validResetToken');
    Route::post('update-password', 'AuthController@updatePassword');
});

Route::middleware('auth:sanctum')->group(function () {
    //LOGOUT
    Route::get('auth/logout', 'AuthController@logout');

    //PROFILE
    Route::prefix('profile')->group(function () {
        Route::get('get', 'ProfileController@get');
        Route::put('update', 'ProfileController@update');
    });

    //DASHBOARD
    Route::prefix('home')->group(function () {
        Route::get('get-all', 'HomeController@getAll');
        Route::get('search', 'HomeController@search');
    });

    //TOPIC
    Route::prefix('topic')->group(function () {
        Route::get('get', 'TopicController@index');
        Route::get('get-one/{topic}', 'TopicController@show');
        Route::get('get-all', 'TopicController@getAll');
        Route::get('get-with-posts', 'TopicController@getWithPosts');
        Route::post('store', 'TopicController@store');
        Route::put('update/{topic}', 'TopicController@update');
        Route::delete('delete/{topic}', 'TopicController@destroy');
    });

    //POST
    Route::prefix('post')->group(function () {
        Route::get('lastest', 'PostController@getLastestPost');
        Route::get('in-topic', 'PostController@getPostsInTopic');

        Route::get('get', 'PostController@index');
        Route::get('get-one', 'PostController@detail');
        Route::get('get-data-create', 'PostController@getDataCreate');
        Route::post('store', 'PostController@store');
        Route::middleware('can:updatePost,post')->group(function () {
            Route::put('update/{post}', 'PostController@update');
            Route::delete('delete/{post}', 'PostController@destroy');
        });
        Route::delete('pin/{post}', 'PostController@pinPost');
    });


    // Tag
    Route::prefix('tag')->group(function () {
        Route::get('get', 'TagController@getList');
        Route::get('get-all', 'TagController@getAll');
        Route::get('get-one/{tag}', 'TagController@getOne');
        Route::post('store', 'TagController@store');
        Route::put('update/{tag}', 'TagController@update');
        Route::delete('delete/{tag}', 'TagController@destroy');
    });

    //COMPANY
    Route::prefix('company')->group(function () {
        Route::get('get', "CompanyController@getList");
        Route::get('get-all', 'CompanyController@getAll');
        Route::get('get-one/{company}', 'CompanyController@getOne');
        Route::post('store', 'CompanyController@store');
        Route::put('update/{company}', 'CompanyController@update');
        Route::delete('delete/{company}', 'CompanyController@destroy');
    });

    //ROLE
    Route::prefix('role')->group(function () {
        Route::get('get-all', 'UserController@getRoles');
    });

    //USER
    Route::prefix('user')->group(function () {
        Route::get('get', 'UserController@get');
        Route::get('get-one/{user}', 'UserController@getOne');
        Route::post('email-exists', 'UserController@emailExists');
        Route::post('store', 'UserController@store');
        Route::put('update/{user}', 'UserController@update');
        Route::delete('delete/{id}', 'UserController@delete');
    });

    //COMMENT
    Route::prefix('comment')->group(function () {
        Route::get('get-in-post', 'CommentController@getComment');
        Route::post('store/{post}', 'commentController@store');
        Route::get('reaction/{id}', 'commentController@reaction');
        Route::get('resolved/{comment}', 'commentController@resolved');
    });
});
