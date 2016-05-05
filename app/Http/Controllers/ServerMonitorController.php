<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ServerMonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $server_list = $this->getServerList();
        $server_status = $this->getServerStatus();
        return view('backend.server_monitor', ["server_status" => $server_status]);
        // return view('backend.server_monitor');
    }

    public function checkServerStatus($returnJSON = TRUE) {
        $server_status = $this->getServerStatus();
        $return = ($returnJSON ? json_encode($server_status):$server_status);
        return $return;
    }

    private function getServerList() {

        //internal server list
        $server_list = array(
            "vm_server" => array("fullname" => "虚拟伺服器", "ip" => "192.168.10.10", "status" => "pending"),
            "domain_server" => array("fullname" => "域和文件服务器", "ip" => "192.168.10.11", "status" => "pending"),
            "mail_server" => array("fullname" => "邮件服务器", "ip" => "192.168.10.12", "status" => "pending"),
            "ricoh_printer" => array("fullname" => "Ricoh 打印机", "ip" => "192.168.10.254", "status" => "pending"),
            "test_fail" => array("fullname" => "演示测试失败 (忽视  )", "ip" => "192.168.10.200", "status" => "pending")
        );

        return $server_list;
    }

    public function checkConnection($detail) {

        exec("ping ".$detail['ip']." -n 1", $output, $return_var);

        $output2 = explode("=", $output[2]); //回覆自 192.168.10.125: 目的地主機無法連線。

        return is_numeric(end($output2)) ? TRUE: FALSE; 

    }

    public function checkConnectionByIP(Request $request) {

        exec("ping ".$request->input('ip')." -n 1", $output, $return_var);

        $output2 = explode("=", $output[2]); //回覆自 192.168.10.125: 目的地主機無法連線。

        return is_numeric(end($output2)) ? 1: 0; 

    }

    private function getServerStatus() {

        $server_list = $this->getServerList();
        foreach($server_list AS $server_type => $detail) {
            
            $connection = $this->checkConnection($detail);
            if($connection) {
                $server_list[$server_type]['status'] = 'passed';
            } else {
                $server_list[$server_type]['status'] = 'failed';
            }
        }

        return $server_list;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}