<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityWagon;
use App\Models\TechnicalSpecTrain;
use App\Models\TechnicalSpecTrainDocument;
use App\Models\TechnicalSpecTrainImage;
use App\Models\TechnicalSpecWagon;
use App\Models\TechnicalSpecWagonDocument;
use App\Models\TechnicalSpecWagonImage;
use App\Models\WagonSubType;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TechnicalSpecificationWagonController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecWagon::with(['wagon_sub_type.wagon_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.technical-specification.wagon.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'wagon_sub_type_id' => $this->postField('wagon_sub_type'),
                    'loading_weight' => $this->postField('loading_weight'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height_from_rail' => $this->postField('height_from_rail'),
                    'axle_load' => $this->postField('axle_load'),
                    'bogie_distance' => $this->postField('bogie_distance'),
                    'usability' => $this->postField('usability'),
                ];
                TechnicalSpecWagon::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $wagon_sub_types = WagonSubType::with(['wagon_type'])->orderBy('code', 'ASC')->get();
        return view('admin.technical-specification.wagon.add')->with([
            'wagon_sub_types' => $wagon_sub_types,
        ]);
    }

    public function patch($id)
    {
        $data = TechnicalSpecWagon::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'wagon_sub_type_id' => $this->postField('wagon_sub_type'),
                    'loading_weight' => $this->postField('loading_weight'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height_from_rail' => $this->postField('height_from_rail'),
                    'axle_load' => $this->postField('axle_load'),
                    'bogie_distance' => $this->postField('bogie_distance'),
                    'usability' => $this->postField('usability'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $wagon_sub_types = WagonSubType::with(['wagon_type'])->orderBy('code', 'ASC')->get();
        return view('admin.technical-specification.wagon.edit')->with([
            'data' => $data,
            'wagon_sub_types' => $wagon_sub_types,
        ]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = TechnicalSpecWagon::with([])->find($id);
            if (!$data) {
                return $this->jsonNotFoundResponse('data not found!');
            }
            TechnicalSpecWagonDocument::with([])->where('ts_wagon_id', '=', $id)->delete();
            TechnicalSpecWagonImage::with([])->where('ts_wagon_id', '=', $id)->delete();
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
            $data = TechnicalSpecWagon::with(['wagon_sub_type.wagon_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function document_page($id)
    {
        $data = TechnicalSpecWagon::with(['wagon_sub_type', 'tech_documents'])->findOrFail($id);
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
                            'ts_wagon_id' => $data->id,
                            'document' => '/tech-document/' . $document,
                            'name' => $originalName
                        ];
                        TechnicalSpecWagonDocument::create($dataDocument);
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
        return view('admin.technical-specification.wagon.document')->with([
            'data' => $data
        ]);
    }

    public function image_page($id)
    {
        $data = TechnicalSpecWagon::with(['wagon_sub_type', 'tech_images'])->findOrFail($id);
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
                            'ts_wagon_id' => $data->id,
                            'image' => '/tech-image/' . $document
                        ];
                        TechnicalSpecWagonImage::create($dataDocument);
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
        return view('admin.technical-specification.wagon.image')->with([
            'data' => $data
        ]);
    }

    public function destroy_document($id)
    {
        try {
            TechnicalSpecWagonDocument::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function destroy_image($id)
    {
        try {
            TechnicalSpecWagonImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
