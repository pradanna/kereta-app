<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\City;
use App\Models\District;

class DistrictController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = District::with(['city'])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.district.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'city_id' => $this->postField('city'),
                    'name' => $this->postField('name'),
                ];
                District::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $cities = City::all();
        return view('admin.master.district.add')->with(['cities' => $cities]);
    }

    public function patch($id)
    {
        $data = District::with(['city'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'city_id' => $this->postField('city'),
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $cities = City::all();
        return view('admin.master.district.edit')->with([
            'data' => $data,
            'cities' => $cities
        ]);
    }

    public function destroy($id)
    {
        try {
            District::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
