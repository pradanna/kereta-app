<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\DirectPassage;
use App\Models\DirectPassageGuard;
use App\Models\DirectPassageHumanResource;
use App\Models\ServiceUnit;

class DirectPassageGuardController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = DirectPassageGuard::with(['direct_passage.sub_track.track', 'direct_passage.city' ,'human_resource'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.direct-passage-guard.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'direct_passage_id' => $this->postField('direct_passage'),
                    'human_resource_id' => $this->postField('human_resource'),
                ];
                DirectPassageGuard::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $direct_passages = DirectPassage::with(['sub_track.track.area'])->orderBy('name', 'ASC')->get();
        $human_resources = DirectPassageHumanResource::with([])->orderBy('name', 'ASC')->get();
        return view('admin.direct-passage-guard.add')->with([
            'direct_passages' => $direct_passages,
            'human_resources' => $human_resources,
        ]);
    }


    public function destroy($id)
    {
        try {
            DirectPassageGuard::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
