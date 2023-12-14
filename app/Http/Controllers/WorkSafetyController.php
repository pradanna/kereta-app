<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\ServiceUnit;
use App\Models\User;
use App\Models\WorkSafety;
use Illuminate\Support\Facades\Hash;

class WorkSafetyController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = WorkSafety::with([])
                ->orderBy('created_at', 'DESC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.work-safety.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'work_unit' => $this->postField('work_unit'),
                    'supervision_consultant' => $this->postField('supervision_consultant'),
                    'contractor' => $this->postField('contractor'),
                    'work_package' => $this->postField('work_package'),
                    'period' => $this->postField('period'),
                    'performance' => $this->postField('performance'),
                    'description' => $this->postField('description'),
                ];
                WorkSafety::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.facility-menu.work-safety.add');
    }

    public function patch($id)
    {
        $data = WorkSafety::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'work_unit' => $this->postField('work_unit'),
                    'supervision_consultant' => $this->postField('supervision_consultant'),
                    'contractor' => $this->postField('contractor'),
                    'work_package' => $this->postField('work_package'),
                    'period' => $this->postField('period'),
                    'performance' => $this->postField('performance'),
                    'description' => $this->postField('description'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.facility-menu.work-safety.edit')->with([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        try {
            WorkSafety::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
