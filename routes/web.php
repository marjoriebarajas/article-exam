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

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/phpinfo', function(){
	phpinfo();
});

Route::get('/', function(){
    return redirect('/login');
});

Route::group(['namespace'=>'Auth'], function(){
    Route::get('/logout', array('as' => 'admin.logout', 'uses' => 'LoginController@logout'));
    Route::group(['prefix'=>'login'], function(){
        Route::get('/',  array('as' => 'admin.get-login', 'uses' => 'LoginController@getLogin'));
        Route::post('/', array('as' => 'admin.post-login', 'uses' => 'LoginController@postLogin'));
    });
    Route::group(['prefix'=>'register'], function(){
        Route::get('/',  array('as' => 'admin.get-register', 'uses' => 'RegisterController@getRegister'));
        Route::post('/', array('as' => 'admin.post-register', 'uses' => 'RegisterController@postRegister'));
    });
});
