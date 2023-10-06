<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Storehouse;

class StoreHouseController extends CustomController
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
        $data = Storehouse::with(['area:id,service_unit_id,name', 'city:id,province_id,name' ,'city.province:id,name'])->get();
        return $this->jsonSuccessResponse('success', $data);
    }

    private function store()
    {
        try {
            $data_request = [
                'name' => $this->postField('name'),
                'type' => $this->postField('type'),
                'city_id' => $this->postField('city_id'),
                'area_id' => $this->postField('area_id'),
                'latitude' => $this->postField('latitude'),
                'longitude' => $this->postField('longitude'),
            ];
            Storehouse::create($data_request);
            return $this->jsonCreatedResponse('success');
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
