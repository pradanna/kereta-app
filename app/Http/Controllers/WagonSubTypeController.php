<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\WagonSubType;
use App\Models\WagonType;

class WagonSubTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = WagonSubType::with(['wagon_type'])
                ->orderBy('wagon_type_id', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.wagon-sub-type.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'wagon_type_id' => $this->postField('wagon_type'),
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                WagonSubType::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $wagon_types = WagonType::with([])->orderBy('code', 'ASC')->get();
        return view('admin.master.wagon-sub-type.add')->with([
            'wagon_types' => $wagon_types
        ]);
    }

    public function patch($id)
    {
        $data = WagonSubType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'wagon_type_id' => $this->postField('wagon_type'),
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $wagon_types = WagonType::with([])->orderBy('code', 'ASC')->get();
        return view('admin.master.wagon-sub-type.edit')->with([
            'data' => $data,
            'wagon_types' => $wagon_types
        ]);
    }

    public function destroy($id)
    {
        try {
            WagonSubType::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
