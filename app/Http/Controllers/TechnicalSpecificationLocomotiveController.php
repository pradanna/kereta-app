<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\FacilityCertification;
use App\Models\FacilityLocomotive;
use App\Models\LocomotiveType;
use App\Models\TechnicalSpecLocomotive;
use App\Models\TechnicalSpecLocomotiveDocument;
use App\Models\TechnicalSpecLocomotiveImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class TechnicalSpecificationLocomotiveController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
        if ($this->request->ajax()) {
            $data = TechnicalSpecLocomotive::with(['locomotive_type'])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.technical-specification.locomotive.index')
            ->with([
                'access' => $access
            ]);
    }

    private $rule = [
        'locomotive_type' => 'required',
        'empty_weight' => 'required',
        'house_power' => 'required',
        'maximum_speed' => 'required',
        'fuel_consumption' => 'required',
        'long' => 'required',
        'width' => 'required',
        'height' => 'required',
        'coupler_height' => 'required',
        'wheel_diameter' => 'required',
    ];

    private $message = [
        'locomotive_type.required' => 'kolom jenis lokomotif wajib di isi',
        'empty_weight.required' => 'kolom berat kosong wajib di isi',
        'house_power.required' => 'kolom horse power wajib di isi',
        'maximum_speed.required' => 'kolom kecepatan maksimum wajib di isi',
        'fuel_consumption.required' => 'kolom konsumsi bbm wajib di isi',
        'long.required' => 'kolom panjang wajib di isi',
        'width.required' => 'kolom lebar wajib di isi',
        'height.required' => 'kolom tinggi wajib di isi',
        'coupler_height.required' => 'kolom tinggi coupler wajib di isi',
        'wheel_diameter.required' => 'kolom diameter roda wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
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
                    'locomotive_type_id' => $this->postField('locomotive_type'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'house_power' => $this->postField('house_power'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'fuel_consumption' => $this->postField('fuel_consumption'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'wheel_diameter' => $this->postField('wheel_diameter'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                TechnicalSpecLocomotive::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $locomotive_types = LocomotiveType::with([])->orderBy('code', 'ASC')->get();
        return view('admin.facility-menu.technical-specification.locomotive.add')->with([
            'locomotive_types' => $locomotive_types,
        ]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = TechnicalSpecLocomotive::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'locomotive_type_id' => $this->postField('locomotive_type'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'house_power' => $this->postField('house_power'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'fuel_consumption' => $this->postField('fuel_consumption'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'wheel_diameter' => $this->postField('wheel_diameter'),
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $locomotive_types = LocomotiveType::with([])->orderBy('code', 'ASC')->get();
        return view('admin.facility-menu.technical-specification.locomotive.edit')->with([
            'data' => $data,
            'locomotive_types' => $locomotive_types,
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        DB::beginTransaction();
        try {
            $data = TechnicalSpecLocomotive::with([])->find($id);
            if (!$data) {
                return $this->jsonNotFoundResponse('data not found!');
            }
            TechnicalSpecLocomotiveDocument::with([])->where('ts_locomotive_id', '=', $id)->delete();
            TechnicalSpecLocomotiveImage::with([])->where('ts_locomotive_id', '=', $id)->delete();
            $data->delete();
            DB::commit();
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = TechnicalSpecLocomotive::with(['locomotive_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function document_page($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
        $data = TechnicalSpecLocomotive::with(['locomotive_type', 'tech_documents'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $originalName = $file->getClientOriginalName();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('tech-document');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'ts_locomotive_id' => $data->id,
                            'document' => '/tech-document/' . $document,
                            'name' => $originalName
                        ];
                        TechnicalSpecLocomotiveDocument::create($dataDocument);
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
        return view('admin.facility-menu.technical-specification.locomotive.document')->with([
            'data' => $data,
            'access' => $access
        ]);
    }

    public function image_page($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
        $data = TechnicalSpecLocomotive::with(['locomotive_type', 'tech_images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('tech-image');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'ts_locomotive_id' => $data->id,
                            'image' => '/tech-image/' . $document
                        ];
                        TechnicalSpecLocomotiveImage::create($dataDocument);
                        $file->move($storage_path, $documentName);
                    }
                    DB::commit();
                    return $this->jsonSuccessResponse('success');
                } else {
                    DB::rollBack();
                    return $this->jsonBadRequestResponse('no image attached...');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonErrorResponse('internal server error');
            }
        }
        return view('admin.facility-menu.technical-specification.locomotive.image')->with([
            'data' => $data,
            'access' => $access
        ]);
    }

    public function destroy_document($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            TechnicalSpecLocomotiveDocument::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function destroy_image($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecLocomotive);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            TechnicalSpecLocomotiveImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
