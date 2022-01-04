<?php

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

Route::get('/', 'PostController@index')->middleware('auth');
Route::group(['middleware'=>'auth'], function(){
    Route::get('/posts/create/{id}', 'PostController@create');
    Route::get('/posts/{post}', 'PostController@show');
    Route::get('/reply/{comment}', 'ReplyController@show');
    Route::get('/games', 'PostController@gamelist');
    Route::get('/games/{game}', 'PostController@gameindex');
    Route::get('/users', 'UserController@userlist');
    Route::get('/users/{id}', 'UserController@userindex');
    Route::post('/posts/reply/reply_store', 'ReplyController@store');
    Route::post('/posts/reply/id', 'ReplyController@reply');
    Route::post('/posts', 'PostController@store');
    Route::post('/like', 'PostController@like');
    Route::post('/replike', 'ReplyController@replike');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
