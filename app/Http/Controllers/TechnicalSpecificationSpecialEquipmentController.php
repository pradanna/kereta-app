<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilitySpecialEquipment;
use App\Models\SpecialEquipmentType;
use App\Models\TechnicalSpecSpecialEquipment;
use App\Models\TechnicalSpecSpecialEquipmentDocument;
use App\Models\TechnicalSpecSpecialEquipmentImage;
use App\Models\TechnicalSpecTrain;
use App\Models\TechnicalSpecTrainDocument;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TechnicalSpecificationSpecialEquipmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.technical-specification.special-equipment.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                TechnicalSpecSpecialEquipment::create($data_request);
                return redirect()->route('technical-specification.special-equipment');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $special_equipment_types = SpecialEquipmentType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.technical-specification.special-equipment.add')->with([
            'special_equipment_types' => $special_equipment_types,
        ]);
    }

    public function patch($id)
    {
        $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $special_equipment_types = SpecialEquipmentType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.technical-specification.special-equipment.edit')->with([
            'data' => $data,
            'special_equipment_types' => $special_equipment_types,
        ]);
    }

    public function destroy($id)
    {
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
        return view('admin.technical-specification.special-equipment.document')->with([
            'data' => $data
        ]);
    }

    public function image_page($id)
    {
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
        return view('admin.technical-specification.special-equipment.image')->with([
            'data' => $data
        ]);
    }

    public function destroy_document($id)
    {
        try {
            TechnicalSpecSpecialEquipmentDocument::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function destroy_image($id)
    {
        try {
            TechnicalSpecSpecialEquipmentImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
