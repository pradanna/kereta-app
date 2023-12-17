<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\SpecialEquipmentType;

class SpecialEquipmentTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = SpecialEquipmentType::with([])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.special-equipment-type.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                SpecialEquipmentType::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.special-equipment-type.add');
    }

    public function patch($id)
    {
        $data = SpecialEquipmentType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.special-equipment-type.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            SpecialEquipmentType::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
