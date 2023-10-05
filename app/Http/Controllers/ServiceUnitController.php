<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\ServiceUnit;

class ServiceUnitController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            return $this->store();
        }
        $data = ServiceUnit::all();
        return $this->jsonSuccessResponse('success', $data);
    }

    public function store()
    {
        try {
            $data = [
                'name' => $this->request->request->get('name')
            ];
            ServiceUnit::create($data);
            return $this->jsonSuccessResponse('success');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
