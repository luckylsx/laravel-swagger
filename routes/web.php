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

Route::get('/test', ['uses' => 'TestController@test']);

Route::get('/swagger/docs', 'SwaggerController@doc');

Route::group(['prefix' => 'swagger'], function () {
    Route::get('json', 'SwaggerController@getJSON');
    Route::get('docOfModule', 'SwaggerController@docOfModule');
});

Route::get('/api/test', 'TestController@test');