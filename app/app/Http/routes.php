<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'v1'], function() {
    Route::resource('user', 'UserController', 
                ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
});

Route::group(['prefix' => 'v2'], function() {
    Route::get('user/names', 'UserController@names');
    Route::resource('user', 'UserController', 
                ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
});
