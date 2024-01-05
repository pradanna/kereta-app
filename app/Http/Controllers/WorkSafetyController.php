<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\NewWorkSafety;
use App\Models\NewWorkSafetyDocument;
use App\Models\NewWorkSafetyReport;
use App\Models\ServiceUnit;
use App\Models\User;
use App\Models\WorkSafety;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class WorkSafetyController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
//        if ($this->request->ajax()) {
//            $data = WorkSafety::with([])
//                ->orderBy('created_at', 'DESC')->get();
//            return $this->basicDataTables($data);
//        }
//        return view('admin.facility-menu.work-safety.index');
        return view('admin.facility-menu.new-work-safety.index');
    }

    private function generateDataMonitoring()
    {
        $param = $this->request->query->get('param');
        $query = NewWorkSafety::with([]);
        if ($param !== '') {
            $query->where(function ($q) use ($param) {
                /** @var $q Builder */
                $q->where('project_name', 'LIKE', '%' . $param . '%')
                    ->orWhere('location', 'LIKE', '%' . $param . '%')
                    ->orWhere('consultant', 'LIKE', '%' . $param . '%');
            });
        }
        return $query->orderBy('created_at', 'DESC')
            ->get();
    }

    public function project_monitoring_page()
    {
        if ($this->request->ajax()) {
            $data = $this->generateDataMonitoring();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.new-work-safety.project-monitoring.index');
    }

    private $rule = [
        'project_name' => 'required',
        'consultant' => 'required',
        'location' => 'required',
    ];

    private $message = [
        'project_name.required' => 'kolom nama proyek wajib di isi',
        'consultant.required' => 'kolom penyedia jasa konsultan wajib di isi',
        'location.required' => 'kolom lokasi pekerjaan wajib di isi',
    ];

    public function project_monitoring_add()
    {
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'project_name' => $this->postField('project_name'),
                    'consultant' => $this->postField('consultant'),
                    'location' => $this->postField('location'),
                    'description' => $this->postField('description'),
                ];
                NewWorkSafety::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.facility-menu.new-work-safety.project-monitoring.add');
    }

    public function project_monitoring_patch($id)
    {
        $data = NewWorkSafety::with([])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'project_name' => $this->postField('project_name'),
                    'consultant' => $this->postField('consultant'),
                    'location' => $this->postField('location'),
                    'description' => $this->postField('description'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.facility-menu.new-work-safety.project-monitoring.edit')->with([
            'data' => $data
        ]);
    }

    public function project_monitoring_destroy($id)
    {
        try {
            NewWorkSafety::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function project_monitoring_detail($id)
    {
        try {
            $data = NewWorkSafety::with([])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function project_monitoring_document($id)
    {
        $data = NewWorkSafety::with(['documents'])->findOrFail($id);
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $originalName = $file->getClientOriginalName();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('work-safety-documents');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'new_work_safety_id' => $data->id,
                            'document' => '/work-safety-documents/' . $document,
                            'name' => $originalName
                        ];
                        NewWorkSafetyDocument::create($dataDocument);
                        $file->move($storage_path, $documentName);
                    }
                    DB::commit();
                    return $this->jsonSuccessResponse('success');
                } else {
                    DB::rollBack();
                    return $this->jsonBadRequestResponse('no documents attached...');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonErrorResponse('internal server error');
            }
        }
        if ($this->request->ajax()) {
            $documents = $data->documents;
            return $this->basicDataTables($documents);
        }
        return view('admin.facility-menu.new-work-safety.project-monitoring.document')
            ->with([
                'data' => $data
            ]);
    }

    public function project_monitoring_document_destroy($id, $document_id)
    {
        try {
            NewWorkSafetyDocument::destroy($document_id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }


    private function generateDataReport()
    {
        $name = $this->request->query->get('name');
        $date = $this->request->query->get('date');
        $query = NewWorkSafetyReport::with([]);
        if ($name !== '') {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        if ($date !== null && $date !== '') {
            $dateParam = Carbon::createFromFormat('F Y', $date);
            $month = $dateParam->format('m');
            $year = $dateParam->format('Y');
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        }
        return $query->orderBy('created_at', 'DESC')
            ->get();
    }


    public function report_page()
    {
        if ($this->request->ajax()) {
            $data = $this->generateDataReport();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.new-work-safety.report.index');
    }

    private $rule_report = [
        'date' => 'required',
        'name' => 'required',
    ];

    private $message_report = [
        'date.required' => 'kolom bulan wajib di isi',
        'name.required' => 'kolom nama laporan wajib di isi',
    ];

    public function report_add()
    {
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule_report, $this->message_report);
                if ($validator->fails()) {
                    $errors = $validator->errors()->getMessages();
                    return response()->json([
                        'status' => 422,
                        'message' => 'Harap Mengisi Kolom Dengan Benar...',
                        'data' => $errors
                    ], 422);
                }
                $date = Carbon::createFromFormat('F Y', $this->postField('date'));
                $dateValue = $date->format('Y-m-d');
                $data_request = [
                    'date' => $dateValue,
                    'name' => $this->postField('name'),
                    'description' => $this->postField('description'),
                ];
                if ($this->request->hasFile('file')) {
                    $file = $this->request->file('file');
                    $extension = $file->getClientOriginalExtension();
                    $document = Uuid::uuid4()->toString() . '.' . $extension;
                    $storage_path = public_path('work-safety-reports');
                    $documentName = $storage_path . '/' . $document;
                    $data_request['document'] = '/work-safety-reports/' . $document;
                    $file->move($storage_path, $documentName);
                }
                NewWorkSafetyReport::create($data_request);
                return $this->jsonSuccessResponse('success');
            } catch (\Exception $e) {
                return $this->jsonErrorResponse('');
            }
        }
        return view('admin.facility-menu.new-work-safety.report.add');
    }

    public function report_patch($id)
    {
        $data = NewWorkSafetyReport::findOrFail($id);
        if ($this->request->method() === 'POST' && $this->request->ajax()) {
            try {
                $validator = Validator::make($this->request->all(), $this->rule_report, $this->message_report);
                if ($validator->fails()) {
                    $errors = $validator->errors()->getMessages();
                    return response()->json([
                        'status' => 422,
                        'message' => 'Harap Mengisi Kolom Dengan Benar...',
                        'data' => $errors
                    ], 422);
                }
                $date = Carbon::createFromFormat('F Y', $this->postField('date'));
                $dateValue = $date->format('Y-m-d');
                $data_request = [
                    'date' => $dateValue,
                    'name' => $this->postField('name'),
                    'description' => $this->postField('description'),
                ];
                if ($this->request->hasFile('file')) {
                    $file = $this->request->file('file');
                    $extension = $file->getClientOriginalExtension();
                    $document = Uuid::uuid4()->toString() . '.' . $extension;
                    $storage_path = public_path('work-safety-reports');
                    $documentName = $storage_path . '/' . $document;
                    $data_request['document'] = '/work-safety-reports/' . $document;
                    $file->move($storage_path, $documentName);
                }
                $data->update($data_request);
                return $this->jsonSuccessResponse('success');
            } catch (\Exception $e) {
                return $this->jsonErrorResponse('');
            }
        }
        return view('admin.facility-menu.new-work-safety.report.edit')->with([
            'data' => $data
        ]);
    }

    public function report_destroy($id)
    {
        try {
            NewWorkSafetyReport::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    //old work safety method
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
