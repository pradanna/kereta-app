<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SubTrackController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master-data.sub-track.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPMasterSubTrack);
        if ($this->request->ajax()) {
            $data = $this->generateData();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.sub-track.index')->with([
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
        $access = $this->getRoleAccess(Formula::APPMasterSubTrack);
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
                SubTrack::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.sub-track.add')->with([]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterSubTrack);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = SubTrack::findOrFail($id);
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
        return view('admin.master-data.sub-track.edit')->with([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMasterSubTrack);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            SubTrack::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $data = $this->generateData();
        $fileName = 'data_petak_' . date('YmdHis') . '.xlsx';
        return Excel::download(
            new \App\Exports\Master\SubTrack($data),
            $fileName
        );
    }

    private function generateData()
    {
        $name = $this->request->query->get('name');
        $query = SubTrack::with([]);
        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                /** @var Builder $q */
                $q->where('code', 'LIKE', '%' . $name . '%')
                    ->orWhere('name', 'LIKE', '%' . $name . '%');
            });
        }
        return $query->orderBy('created_at', 'ASC')->get();
    }

    public function getSubTrackByServiceUnit()
    {
        try {
            $service_unit = $this->request->query->get('service_unit');
            $query = SubTrack::with(['track.area.service_unit']);
            if ($service_unit !== '') {
                $query->whereHas('track', function ($qs) use ($service_unit) {
                    /** @var Builder $qs */
                    return $qs->whereHas('area', function ($qa) use ($service_unit) {
                        /** @var Builder $qa */
                        return $qa->where('service_unit_id', '=', $service_unit);
                    });
                });
            }
            $data = $query->orderBy('name', 'ASC')->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
