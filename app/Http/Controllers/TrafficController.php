<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;

class TrafficController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.traffic.index');
    }
}
