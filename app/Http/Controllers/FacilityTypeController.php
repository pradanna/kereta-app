<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityType;

class FacilityTypeController extends CustomController
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
        $data = FacilityType::all();
        return $this->jsonSuccessResponse('success', $data);
    }

    private function store()
    {
        try {
            $data_request = [
                'name' => $this->postField('name')
            ];
            FacilityType::create($data_request);
            return $this->jsonCreatedResponse('success');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('error ', $e->getMessage());
        }

    }
}
