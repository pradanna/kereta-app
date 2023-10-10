<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\LocomotiveType;

class LocomotiveTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = LocomotiveType::with([])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.locomotive-type.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                    'type' => $this->postField('type'),
                ];
                LocomotiveType::create($data_request);
                return redirect()->route('locomotive-type');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        return view('admin.master.locomotive-type.add');
    }
}
