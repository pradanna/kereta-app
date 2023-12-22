<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\FacilitySpecialEquipment;
use App\Models\SpecialEquipmentType;
use App\Models\TechnicalSpecSpecialEquipment;
use App\Models\TechnicalSpecSpecialEquipmentDocument;
use App\Models\TechnicalSpecSpecialEquipmentImage;
use App\Models\TechnicalSpecTrain;
use App\Models\TechnicalSpecTrainDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class TechnicalSpecificationSpecialEquipmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
        if ($this->request->ajax()) {
            $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type'])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.technical-specification.special-equipment.index')->with([
            'access' => $access
        ]);
    }

    private $rule = [
        'special_equipment_type' => 'required',
        'empty_weight' => 'required',
        'maximum_speed' => 'required',
        'passenger_capacity' => 'required',
        'long' => 'required',
        'width' => 'required',
        'height' => 'required',
        'spoor_width' => 'required',
    ];

    private $message = [
        'special_equipment_type.required' => 'kolom jenis lokomotif wajib di isi',
        'empty_weight.required' => 'kolom berat kosong wajib di isi',
        'maximum_speed.required' => 'kolom kecepatan maksimum wajib di isi',
        'passenger_capacity.required' => 'kolom kapasitas penumpang wajib di isi',
        'long.required' => 'kolom panjang wajib di isi',
        'width.required' => 'kolom lebar wajib di isi',
        'height.required' => 'kolom tinggi wajib di isi',
        'spoor_width.required' => 'kolom lebar spoor wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
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
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => 0,
                    'spoor_width' => $this->postField('spoor_width'),
                    'axle_load' => 0,
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                TechnicalSpecSpecialEquipment::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $special_equipment_types = SpecialEquipmentType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.technical-specification.special-equipment.add')->with([
            'special_equipment_types' => $special_equipment_types,
        ]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => 0,
                    'spoor_width' => $this->postField('spoor_width'),
                    'axle_load' => 0,
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $special_equipment_types = SpecialEquipmentType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.technical-specification.special-equipment.edit')->with([
            'data' => $data,
            'special_equipment_types' => $special_equipment_types,
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        DB::beginTransaction();
        try {
            $data = TechnicalSpecSpecialEquipment::with([])->find($id);
            if (!$data) {
                return $this->jsonNotFoundResponse('data not found!');
            }
            TechnicalSpecSpecialEquipmentDocument::with([])->where('ts_special_equipment_id', '=', $id)->delete();
            TechnicalSpecSpecialEquipmentImage::with([])->where('ts_special_equipment_id', '=', $id)->delete();
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
            $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function document_page($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
        $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type', 'tech_documents'])->findOrFail($id);
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
                            'ts_special_equipment_id' => $data->id,
                            'document' => '/tech-document/' . $document,
                            'name' => $originalName
                        ];
                        TechnicalSpecSpecialEquipmentDocument::create($dataDocument);
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
        return view('admin.facility-menu.technical-specification.special-equipment.document')->with([
            'data' => $data,
            'access' => $access
        ]);
    }

    public function image_page($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
        $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type', 'tech_images'])->findOrFail($id);
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
                            'ts_special_equipment_id' => $data->id,
                            'image' => '/tech-image/' . $document
                        ];
                        TechnicalSpecSpecialEquipmentImage::create($dataDocument);
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
        return view('admin.facility-menu.technical-specification.special-equipment.image')->with([
            'data' => $data,
            'access' => $access
        ]);
    }

    public function destroy_document($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            TechnicalSpecSpecialEquipmentDocument::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function destroy_image($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecSpecialEquipment);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            TechnicalSpecSpecialEquipmentImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
