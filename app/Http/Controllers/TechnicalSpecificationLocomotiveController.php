<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityCertification;
use App\Models\FacilityLocomotive;
use App\Models\LocomotiveType;
use App\Models\TechnicalSpecLocomotive;
use App\Models\TechnicalSpecLocomotiveDocument;
use App\Models\TechnicalSpecLocomotiveImage;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TechnicalSpecificationLocomotiveController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecLocomotive::with(['locomotive_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.technical-specification.locomotive.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
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
        $data = TechnicalSpecLocomotive::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
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
            'data' => $data
        ]);
    }

    public function image_page($id)
    {
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
            'data' => $data
        ]);
    }

    public function destroy_document($id)
    {
        try {
            TechnicalSpecLocomotiveDocument::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function destroy_image($id)
    {
        try {
            TechnicalSpecLocomotiveImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
