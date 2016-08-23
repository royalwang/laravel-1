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



Route::group(['middleware' => ['auth','permissions' ]], function ($route) {    

    Route::resource('/'                                       , 'HomeController');

    Route::group(['namespace' => 'Setting'], function () {    
        Route::resource('/setting/users'                      , 'Users');
        Route::resource('/setting/roles'                      , 'Roles');
        Route::resource('/setting/permissions'                , 'Permissions');
    });

    Route::group(['namespace' => 'AD'], function () {    
        Route::resource('/ad/table'                           , 'Table');
        Route::resource('/ad/tablestyle'                      , 'TableStyle');
        Route::resource('/ad/accounts'                        , 'Accounts');
        Route::resource('/ad/vps'                             , 'Vps');
    });


    
});










