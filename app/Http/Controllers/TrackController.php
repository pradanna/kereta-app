<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityTrain;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class TrackController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $service_unit = $this->request->query->get('service_unit');
            $area = $this->request->query->get('area');
            $name = $this->request->query->get('name');

            $query = Track::with(['area']);

            if ($service_unit !== '' && $service_unit !== null) {
                $query->where('area', function ($qa) use ($service_unit){
                    /** @var $qa Builder */
                    return $qa->where('service_unit_id', '=', $service_unit);
                });
            }
            if ($area !== '') {
                $query->where('area_id', '=', $area);
            }

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
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master.track.index')->with([
            'areas' => $areas,
        ]);
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                Track::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areas = Area::with(['service_unit'])->orderBy('name', 'ASC')
            ->get();
        return view('admin.master.track.add')->with(['areas' => $areas]);
    }

    public function patch($id)
    {
        $data = Track::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }

        }
        $areas = Area::all();
        return view('admin.master.track.edit')->with([
            'data' => $data,
            'areas' => $areas
        ]);
    }

    public function destroy($id)
    {
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
