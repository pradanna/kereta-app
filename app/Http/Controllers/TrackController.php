<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityTrain;
use App\Models\ServiceUnit;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TrackController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master-data.track.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPMasterTrack);
        if ($this->request->ajax()) {
            $name = $this->request->query->get('name');
            $query = Track::with(['area']);
            if ($name !== '') {
                $query->where(function ($q) use ($name) {
                    /** @var $q Builder */
                    $q->where('code', 'LIKE', '%' . $name . '%')
                        ->orWhere('name', 'LIKE', '%' . $name . '%');
                });
            }
            $data = $query->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.track.index')->with([
            'access' => $access,
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
        $access = $this->getRoleAccess(Formula::APPMasterTrack);
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
                ];
                Track::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.track.add')->with([]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterTrack);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = Track::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
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
        return view('admin.master-data.track.edit')->with([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterTrack);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            Track::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'data_perlintasan_' . date('YmdHis') . '.xlsx';
        $area = $this->request->query->get('area');
        $name = $this->request->query->get('name');

        $query = Track::with(['area']);
        if ($area !== '') {
            $query->where('area_id', '=', $area);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                $q->where('code', 'LIKE', '%' . $name . '%')
                    ->orWhere('name', 'LIKE', '%' . $name . '%');
            });
        }
        $data = $query->orderBy('created_at', 'ASC')->get();
        return Excel::download(
            new \App\Exports\Master\Track($data),
            $fileName
        );
    }

    public function getDataByArea()
    {
        try {
            $service_unit = $this->request->query->get('service_unit');
            $area = $this->request->query->get('area');
            $query = Track::with(['area']);

            if ($service_unit !== '' && $service_unit !== null) {
                $query->whereHas('area', function ($qa) use ($service_unit) {
                    /** @var $qa Builder */
                    return $qa->where('service_unit_id', '=', $service_unit);
                });
            }
            if ($area !== '') {
                $query->where('area_id', '=', $area);
            }
            $data = $query->orderBy('created_at', 'ASC')->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
