<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\WagonSubType;
use App\Models\WagonType;
use Illuminate\Support\Facades\Validator;

class WagonSubTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPMasterSubWagonType);
        if ($this->request->ajax()) {
            $data = WagonSubType::with(['wagon_type'])
                ->orderBy('wagon_type_id', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.wagon-sub-type.index')->with([
            'access' => $access
        ]);
    }

    private $rule = [
        'wagon_type' => 'required',
        'code' => 'required',
        'name' => 'required',
    ];

    private $message = [
        'wagon_type.required' => 'kolom jenis gerbong wajib di isi',
        'code.required' => 'kolom kode wajib di isi',
        'name.required' => 'kolom nama wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPMasterSubWagonType);
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
        return view('admin.master-data.wagon-sub-type.add')->with([
            'wagon_types' => $wagon_types
        ]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterSubWagonType);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = WagonSubType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
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
        return view('admin.master-data.wagon-sub-type.edit')->with([
            'data' => $data,
            'wagon_types' => $wagon_types
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterSubWagonType);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            WagonSubType::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
