<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\DirectPassageHumanResource;
use Carbon\Carbon;

class DirectPassageHumanResourceController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = DirectPassageHumanResource::with([])->orderBy('name', 'ASC')->get()->append(['expired_in']);
            return $this->basicDataTables($data);
        }
        return view('admin.master.direct-passage-guard.index');
    }
    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'name' => $this->postField('name'),
                    'skill_card_id' => $this->postField('skill_card'),
                    'training_card_id' => $this->postField('training_card'),
                    'card_expired' => $this->postField('card_expired') === '' ? null : Carbon::createFromFormat('d-m-Y', $this->postField('card_expired'))->format('Y-m-d'),
                ];
                DirectPassageHumanResource::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master.direct-passage-guard.add');
    }

    public function patch($id)
    {
        $data = DirectPassageHumanResource::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
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
        return view('admin.master.locomotive-type.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            DirectPassageHumanResource::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
