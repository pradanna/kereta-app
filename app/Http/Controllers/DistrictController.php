<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\City;
use App\Models\District;
use Illuminate\Support\Facades\Validator;

class DistrictController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPMasterDistrict);
        if ($this->request->ajax()) {
            $data = District::with(['city'])->orderBy('created_at', 'DESC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.district.index')
            ->with([
                'access' => $access
            ]);
    }

    private $rule = [
        'city' => 'required',
        'name' => 'required',
    ];

    private $message = [
        'city.required' => 'kolom kota/kabupaten wajib di isi',
        'name.required' => 'kolom nama wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPMasterDistrict);
        if (!$access['is_granted_create']) {
            abort(403);
        }
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
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
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master-data.district.add')->with(['cities' => $cities]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterDistrict);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = District::with(['city'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
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
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master-data.district.edit')->with([
            'data' => $data,
            'cities' => $cities
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterDistrict);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            District::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
