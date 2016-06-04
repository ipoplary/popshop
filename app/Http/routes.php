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

Route::group(['namespace' => 'Admin', 'domain' => 'admin.popshop.dev', 'as' => 'admin'], function () {

        Route::get('login', 'AuthController@getLogin');
        Route::post('login', 'AuthController@postLogin');

        Route::get('register', 'AuthController@getRegister');
        Route::post('register', 'AuthController@postRegister');

        Route::get('test', 'AuthController@getTest');

        // Route::controller('/', 'HomeController');
        Route::controller('home', 'HomeController');
});


// Route::get('/', function () {
//     return view('welcome');
// });