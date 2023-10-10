<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\TrainType;

class TrainTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TrainType::with([])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.train-type.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                TrainType::create($data_request);
                return redirect()->route('train-type');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        return view('admin.master.train-type.add');
    }
}
