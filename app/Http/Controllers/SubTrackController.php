<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\SubTrack;
use App\Models\Track;
use Maatwebsite\Excel\Facades\Excel;

class SubTrackController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = $this->generateData();
            return $this->basicDataTables($data);
        }

        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master.sub-track.index')->with([
            'areas' => $areas,
        ]);
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'track_id' => $this->postField('track'),
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                SubTrack::create($data_request);
                return redirect()->route('sub-track');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        $tracks = Track::all();
        return view('admin.master.sub-track.add')->with(['tracks' => $tracks]);
    }

    public function patch($id)
    {
        $data = SubTrack::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'track_id' => $this->postField('track'),
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }

        }
        $tracks = Track::all();
        return view('admin.master.sub-track.edit')->with([
            'data' => $data,
            'tracks' => $tracks
        ]);
    }

    public function destroy($id)
    {
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
        $area = $this->request->query->get('area');
        $track = $this->request->query->get('track');
        $name = $this->request->query->get('name');

        $query = SubTrack::with(['track.area']);
        if ($area !== '') {
            $query->whereHas('track', function ($q) use ($area){
                return $q->where('area_id', '=', $area);
            });
        }

        if ($track !== '') {
            $query->where('track_id', '=', $track);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                $q->where('code', 'LIKE', '%' . $name . '%')
                    ->orWhere('name', 'LIKE', '%' . $name . '%');
            });
        }

        return $query->orderBy('created_at', 'ASC')->get();
    }
}
