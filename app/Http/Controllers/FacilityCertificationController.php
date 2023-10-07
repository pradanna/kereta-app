<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityCertification;
use App\Models\Storehouse;

class FacilityCertificationController extends CustomController
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
        $data = FacilityCertification::with(['area', 'storehouse', 'facility_type'])->get()->append(['expired_in', 'status']);
        return $this->jsonSuccessResponse('success', $data);
    }

    private function store()
    {
        try {
            $data_request = [
                'area_id' => $this->postField('area_id'),
                'storehouse_id' => $this->postField('storehouse_id'),
                'facility_type_id' => $this->postField('facility_type_id'),
                'ownership' => $this->postField('ownership'),
                'facility_number' => $this->postField('facility_number'),
                'service_start_date' => $this->postField('service_start_date'),
                'service_expired_date' => $this->postField('service_expired_date'),
                'testing_number' => $this->postField('testing_number'),
            ];
            FacilityCertification::create($data_request);
            return $this->jsonCreatedResponse('success');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
