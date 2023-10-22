<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\Track;

class TrackController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Track::with(['area'])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.track.index');
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
                return redirect()->route('track');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        $areas = Area::all();
        return view('admin.master.track.add')->with(['areas' => $areas]);
    }
}
