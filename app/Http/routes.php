<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Sub Domain Routes
|--------------------------------------------------------------------------
|
| This route is for admin.beijingsecgroup.com
|
*/

use App\Classes\Test;
use App\Helpers\Helper;

Route::group(['middleware' => ['web']], function () {

    /*Admin Page*/
    Route::get('/server/monitor', 'ServerMonitorController@index')->name('server-monitor');
    Route::get('/server/checkserverstatus', 'ServerMonitorController@checkServerStatus')->name('server-status');

/*    Route::get('/test', array('as' => 'admin-homepage', function () {
        return view('backend.test');
    }));*/
    Route::post('/server/checkconnectionbyip', 'ServerMonitorController@checkConnectionByIP');

});

