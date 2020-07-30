<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'PostController@index')->name('home');
Route::get('/post/{id}', 'PostController@show')->name('post');
Route::delete('/post{id}', 'PostController@destroy');

Auth::routes();

Route::get('/create', 'PostController@create')->name('create');
Route::post('/', 'PostController@store');
Route::delete('/post/{id}/delete', 'PostController@destroy');

Route::post('/comment', 'CommentController@create');
Route::post('/comment/{id}/like', 'CommentController@like');
Route::delete('/comment/{id}/dislike', 'CommentController@dislike');
