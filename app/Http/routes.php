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

    Route::resource('/'                                           , 'HomeController');
    
    Route::group(['namespace' => 'Setting'], function () {    
        //data upload download
        Route::post('/setting/users/upload'                       , 'Users@upload')->name('setting.users.upload');
        Route::post('/setting/roles/upload'                       , 'Roles@upload')->name('setting.roles.upload');
        Route::post('/setting/permissions/upload'                 , 'Permissions@upload')->name('setting.permissions.upload');
        Route::get('/setting/users/download'                      , 'Users@download')->name('setting.users.download');
        Route::get('/setting/roles/download'                      , 'Roles@download')->name('setting.roles.download');
        Route::get('/setting/permissions/download'                , 'Permissions@download')->name('setting.permissions.download');
        //page
        Route::resource('/setting/users'                          , 'Users');
        Route::resource('/setting/roles'                          , 'Roles');
        Route::resource('/setting/permissions'                    , 'Permissions');
   
    });

    Route::group(['namespace' => 'Chart'], function () {  
        Route::group(['namespace' => 'Ad'], function () {
            Route::resource('/chart/ad/records/table'             , 'Records\Table');
            Route::resource('/chart/ad/lines'                     , 'Lines');
			Route::resource('/chart/ad/bars'                      , 'Bars');
        });  
    });

    Route::group(['namespace' => 'Data'], function () {    
        Route::group(['namespace' => 'Ad'], function () {    
            //ajax
            Route::resource('/data/ad/accounts/ajax'              , 'AccountsAjax');
            Route::resource('/data/ad/vps/ajax'                   , 'VpsAjax');
            Route::resource('/data/ad/binds/ajax'                 , 'BindsAjax');
            Route::resource('/data/ad/records/ajax'               , 'RecordsAjax');  
            //data upload download
            Route::post('/data/ad/records/upload'                 , 'Records@upload')->name('data.ad.records.upload');
            Route::post('/data/ad/accounts/upload'                , 'Accounts@upload')->name('data.ad.accounts.upload');
            Route::post('/data/ad/vps/upload'                     , 'Vps@upload')->name('data.ad.vps.upload');
            Route::post('/data/ad/binds/upload'                   , 'Binds@upload')->name('data.ad.binds.upload');    
            Route::get('/data/ad/records/download'                , 'Records@download')->name('data.ad.records.download');
            Route::get('/data/ad/accounts/download'               , 'Accounts@download')->name('data.ad.accounts.download');
            Route::get('/data/ad/vps/download'                    , 'Vps@download')->name('data.ad.vps.download');
            Route::get('/data/ad/binds/download'                  , 'Binds@download')->name('data.ad.binds.download');     
            //page
            Route::resource('/data/ad/records'                    , 'Records');
            Route::resource('/data/ad/accounts'                   , 'Accounts');
            Route::resource('/data/ad/vps'                        , 'Vps');
            Route::resource('/data/ad/binds'                      , 'Binds');   
        });
        
        Route::group(['namespace' => 'Site'], function () {    
            //ajax
            Route::resource('/data/site/sites/ajax'               , 'SitesAjax');
            //data upload download
            Route::post('/data/site/sites/upload'                 , 'Sites@upload')->name('data.site.sites.upload');
            Route::post('/data/site/banners/upload'               , 'Banners@upload')->name('data.site.banners.upload');
            Route::post('/data/site/paychannels/upload'           , 'PayChannels@upload')->name('data.site.paychannels.upload');  
            Route::post('/data/site/orders/upload'                , 'Orders@upload')->name('data.site.orders.upload'); 
            Route::get('/data/site/sites/download'                , 'Sites@download')->name('data.site.sites.download');
            Route::get('/data/site/banners/download'              , 'Banners@download')->name('data.site.banners.download');
            Route::get('/data/site/paychannels/download'          , 'PayChannels@download')->name('data.site.paychannels.download');
            Route::get('/data/site/orders/download'               , 'Orders@download')->name('data.site.orders.download'); 
            //page
            Route::resource('/data/site/sites'                    , 'Sites');
            Route::resource('/data/site/banners'                  , 'Banners');
            Route::resource('/data/site/paychannels'              , 'PayChannels');
			Route::resource('/data/site/orders'                   , 'Orders');
        });    
    });

    Route::group(['namespace' => 'Style'], function () {  
        Route::group(['namespace' => 'Ad'], function () {
            Route::resource('/style/ad/records/table'             , 'Records\Table');
        });  
    });
    
});









