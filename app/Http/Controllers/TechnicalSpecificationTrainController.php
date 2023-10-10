<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;

class TechnicalSpecificationTrainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.technical-specification.train.index');
    }
}
