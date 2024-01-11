<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\LocomotiveType;
use Illuminate\Support\Facades\Validator;

class LocomotiveTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPMasterLocomotiveType);
        if ($this->request->ajax()) {
            $data = LocomotiveType::with([])->orderBy('created_at', 'DESC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.locomotive-type.index')->with([
            'access' => $access
        ]);
    }

    private $rule = [
        'code' => 'required',
        'name' => 'required',
    ];

    private $message = [
        'code.required' => 'kolom kode wajib di isi',
        'name.required' => 'kolom nama wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPMasterLocomotiveType);
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
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                    'type' => 'general-motor',
                ];
                LocomotiveType::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.locomotive-type.add');
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterLocomotiveType);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = LocomotiveType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                    'type' => 'general-motor',
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.locomotive-type.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterLocomotiveType);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            LocomotiveType::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
