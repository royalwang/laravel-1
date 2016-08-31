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

    Route::group(['namespace' => 'Chart'], function () {  
        Route::group(['namespace' => 'Ad'], function () {
            Route::resource('/chart/ad/table'                     , 'Table');
        });  
    });

    Route::group(['namespace' => 'Data'], function () {    
        Route::group(['namespace' => 'Ad'], function () {    
            //ajax
            Route::get('/data/ad/accounts/ajax'                   , 'Accounts@ajax');
            Route::get('/data/ad/vps/ajax'                        , 'Vps@ajax');
            Route::post('/data/ad/binds/ajax/disable'             , 'Binds@ajaxDisable');  
            //page
            Route::resource('/data/ad/records'                    , 'Records');
            Route::resource('/data/ad/accounts'                   , 'Accounts');
            Route::resource('/data/ad/vps'                        , 'Vps');
            Route::resource('/data/ad/binds'                      , 'Binds');     
        });
        
        Route::group(['namespace' => 'Site'], function () {    
            //ajax
            Route::get('/data/site/sites/ajax'                    , 'Sites@ajax');
            //page
            Route::resource('/data/site/sites'                    , 'Sites');
            Route::resource('/data/site/banners'                  , 'Banners');
            Route::resource('/data/site/paychannel'               , 'PayChannel');
        });    
    });

    
});










