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

Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

// Registration Routes...


// Password Reset Routes...
//Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
//Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
//Route::post('password/reset', 'Auth\PasswordController@reset');


Route::group(['middleware' => 'auth'], function () {    
    
	Route::get('/',                         'HomeController@index');
    Route::get('/home',                     'HomeController@index');
    //Route::get('/table',                    'TableController@index');
    Route::get('/tablestyle',               'ADTableStyleController@index');

    //AJAX
    Route::post('/ajax/adtablestyle',       'Ajax\ADTableStyle@index');
    Route::post('/ajax/adtable',            'Ajax\ADTable@index');
    
    Route::group(['middleware' => 'user_group:responsible'] ,function(){
        Route::get('/users',                'UsersController@index');
        Route::get('/account',              'AccountController@index');
        //AJAX
        Route::post('/ajax/users',          'Ajax\Users@index');
        Route::post('/ajax/users/add',      'Ajax\Users@add');
        Route::post('/ajax/account',        'Ajax\ADAccount@index');
        Route::post('/ajax/account/add',        'Ajax\ADAccount@add');
        
    });

    Route::group(['middleware' => 'user_group:advertising'] ,function(){
        //AJAX
        Route::post('/ajax/adtable/update', 'Ajax\ADTable@update');
    });

    //test
    Route::get('/ajax/adtable'    ,'Ajax\ADTable@index');
    Route::get('/ajax/users/add'  ,'Ajax\Users@add');
    Route::get('/ajax/account'    ,'Ajax\ADAccount@index');
    Route::get('/test'            ,'Ajax\ADTable@update');
	    

	
});








