<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\DisasterType;
use Illuminate\Support\Facades\Validator;

class DisasterTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPMasterTrack);
        if ($this->request->ajax()) {
            $data = DisasterType::with([])->orderBy('name', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.disaster-type.index')->with([
            'access' => $access,
        ]);
    }

    private $rule = [
        'name' => 'required',
    ];

    private $message = [
        'name.required' => 'kolom nama wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPMasterDisasterType);
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
                    'name' => $this->postField('name'),
                ];
                DisasterType::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.disaster-type.add');
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterDisasterType);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = DisasterType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.disaster-type.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterDisasterType);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            DisasterType::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
