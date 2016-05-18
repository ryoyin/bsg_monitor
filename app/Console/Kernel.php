<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {

            $server_list = array(
                "vm_server"        => array("fullname" => "虚拟伺服器", "ip" => "192.168.10.10"),
                "domain_server"    => array("fullname" => "域和文件服务器", "ip" => "192.168.10.11"),
                "mail_server"      => array("fullname" => "邮件服务器", "ip" => "192.168.10.12"),
                "ricoh_printer"    => array("fullname" => "Ricoh 打印机", "ip" => "192.168.10.254"),
                "cctv"             => array("fullname" => "CCTV 閉路電視", "ip" => "192.168.10.31"),
                "avaya_ms_server"  => array("fullname" => "Avaya MS Window Server 2008", "ip" => "192.168.10.20"),
                "avaya_app_server" => array("fullname" => "Avaya Application Server", "ip" => "192.168.10.19"),
                "avaya_ipo"        => array("fullname" => "Avaya IPO Server", "ip" => "192.168.10.18"),
                "test"             => array("fullname" => "Testing Connection", "ip" => "192.168.10.15")
            );

            foreach($server_list AS $server) {

                $command = "ping ".$server['ip']." -c 1";

                exec($command, $output, $return_var);

                if(strstr($output[4], '1 received') === FALSE) {

                    unset($output);

                    exec($command, $output, $return_var);

                    if(strstr($output[4], '1 received') === FALSE) {

                        Mail::raw('Ping fail to server: ' . $server['fullname'], function ($message) use ($server) {
                            $message->from('royho@beijingsecgroup.com');
                            $message->to('royho@beijingsecgroup.com')->subject($server['fullname'] . 'Ping Fail!');
                        });
                    }

                }

                unset($output);

            }

        })->everyMinute();

        $schedule->call(function () {

        })->hourly();

    }
}
