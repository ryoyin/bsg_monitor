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

//use App\Classes\Test;
//use App\Helpers\Helper;

Route::post('/server/checkconnectionbyip', 'ServerMonitorController@checkConnectionByIP');

Route::group(['middleware' => ['web']], function () {

    /*Admin Page*/

    Route::get('/server/monitor', 'ServerMonitorController@index')->name('server-monitor');
    Route::get('/server/checkserverstatus', 'ServerMonitorController@checkServerStatus')->name('server-status');

/*    Route::get('/test', array('as' => 'admin-homepage', function () {
        return view('backend.test');
    }));*/


});

Route::get('servertest', function() {

    $server_list = array(
        "vm_server"     => array("fullname" => "虚拟伺服器", "ip" => "192.168.10.10"),
        "domain_server" => array("fullname" => "域和文件服务器", "ip" => "192.168.10.11"),
        "mail_server"   => array("fullname" => "邮件服务器", "ip" => "192.168.10.12"),
        "ricoh_printer" => array("fullname" => "Ricoh 打印机", "ip" => "192.168.10.254"),
        "cctv"          => array("fullname" => "CCTV 閉路電視", "ip" => "192.168.10.31"),
        "test"          => array("fullname" => "Test 測試", "ip" => "192.168.10.253")
    );

    foreach($server_list AS $server) {

        $command = "ping ".$server['ip']." -c 1";

        exec($command, $output, $return_var);

        if(strstr($output[4], '1 received') === FALSE) {

            Mail::raw('Ping fail to server: '.$server['fullname'], function ($message) use ($server) {
                $message->from('royho@beijingsecgroup.com');
                $message->to('royho@beijingsecgroup.com')->subject($server['fullname'].'Ping Fail!');
            });

        }

        unset($output);

    }

});
