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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/article', ['as' => 'article.index', 'uses' => 'BlogController@index']);
Route::get('/article/{id}', ['as' => 'article.show', 'uses' => 'BlogController@show'])->where('id', '[0-9]+');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/article/create', ['as' => 'article.create', 'uses' => 'BlogController@create']);
    Route::post('/article/store', ['as' => 'article.store', 'uses' => 'BlogController@store']);
});
