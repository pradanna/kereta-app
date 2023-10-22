<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\SubTrack;
use App\Models\Track;

class SubTrackController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = SubTrack::with(['track'])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.sub-track.index');
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
}
