<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;

class AreaController extends CustomController
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
        $data = Area::with(['service_unit:id,name'])->get();
        return $this->jsonSuccessResponse('success', $data);
    }

    private function store()
    {
        try {
            $data_request = [
                'service_unit_id' => $this->postField('service_unit_id'),
                'name' => $this->postField('name')
            ];
            Area::create($data_request);
            return $this->jsonCreatedResponse('success');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
