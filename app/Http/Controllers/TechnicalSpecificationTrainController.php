<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityTrain;
use App\Models\TechnicalSpecLocomotive;
use App\Models\TechnicalSpecLocomotiveDocument;
use App\Models\TechnicalSpecLocomotiveImage;
use App\Models\TechnicalSpecTrain;
use App\Models\TechnicalSpecTrainDocument;
use App\Models\TechnicalSpecTrainImage;
use App\Models\TrainType;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TechnicalSpecificationTrainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecTrain::with(['train_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.technical-specification.train.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'train_type_id' => $this->postField('train_type'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'air_conditioner' => $this->postField('air_conditioner'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'axle_load' => $this->postField('axle_load'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                TechnicalSpecTrain::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $train_types = TrainType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.technical-specification.train.add')->with([
            'train_types' => $train_types,
        ]);
    }

    public function patch($id)
    {
        $data = TechnicalSpecTrain::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'train_type_id' => $this->postField('train_type'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'air_conditioner' => $this->postField('air_conditioner'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'axle_load' => $this->postField('axle_load'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $train_types = TrainType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.technical-specification.train.edit')->with([
            'data' => $data,
            'train_types' => $train_types,
        ]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = TechnicalSpecTrain::with([])->find($id);
            if (!$data) {
                return $this->jsonNotFoundResponse('data not found!');
            }
            TechnicalSpecTrainDocument::with([])->where('ts_train_id', '=', $id)->delete();
            TechnicalSpecTrainImage::with([])->where('ts_train_id', '=', $id)->delete();
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
            $data = TechnicalSpecTrain::with(['train_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function document_page($id)
    {
        $data = TechnicalSpecTrain::with(['train_type', 'tech_documents'])->findOrFail($id);
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
                            'ts_train_id' => $data->id,
                            'document' => '/tech-document/' . $document,
                            'name' => $originalName
                        ];
                        TechnicalSpecTrainDocument::create($dataDocument);
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
        return view('admin.technical-specification.train.document')->with([
            'data' => $data
        ]);
    }

    public function image_page($id)
    {
        $data = TechnicalSpecTrain::with(['train_type', 'tech_images'])->findOrFail($id);
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
                            'ts_train_id' => $data->id,
                            'image' => '/tech-image/' . $document
                        ];
                        TechnicalSpecTrainImage::create($dataDocument);
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
        return view('admin.technical-specification.train.image')->with([
            'data' => $data
        ]);
    }

    public function destroy_document($id)
    {
        try {
            TechnicalSpecTrainDocument::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function destroy_image($id)
    {
        try {
            TechnicalSpecTrainImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
