<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\WagonSubType;
use App\Models\WagonType;

class WagonTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = WagonType::with([])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.wagon-type.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                WagonType::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master.wagon-type.add');
    }

    public function patch($id)
    {
        $data = WagonType::findOrFail($id);
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
        return view('admin.master.wagon-type.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            WagonType::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function sub_type($id)
    {
        $wagon = WagonType::findOrFail($id);
        if ($this->request->ajax()) {
            $data = WagonSubType::with([])
                ->where('wagon_type_id', '=', $id)
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.wagon-type.sub-type')->with([
            'wagon' => $wagon
        ]);
    }

    public function store_sub_type($id)
    {
        $wagon = WagonType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'wagon_type_id' => $wagon->id,
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                WagonSubType::create($data_request);
                return redirect()->route('wagon-type.sub-type', ['id' => $wagon->id]);
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        return view('admin.master.wagon-type.add-sub-type')->with([
            'wagon' => $wagon
        ]);
    }

    public function patch_sub_type($id, $sub_id)
    {
        $data = WagonSubType::findOrFail($sub_id);
        $wagon = WagonType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'wagon_type_id' => $wagon->id,
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master.wagon-type.edit-sub-type')->with([
            'data' => $data,
            'wagon' => $wagon
        ]);
    }

    public function destroy_sub_type($id, $sub_id)
    {
        try {
            WagonSubType::destroy($sub_id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
