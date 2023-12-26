<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\FacilityWagon;
use App\Models\TechnicalSpecTrain;
use App\Models\TechnicalSpecTrainDocument;
use App\Models\TechnicalSpecTrainImage;
use App\Models\TechnicalSpecWagon;
use App\Models\TechnicalSpecWagonDocument;
use App\Models\TechnicalSpecWagonImage;
use App\Models\WagonSubType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class TechnicalSpecificationWagonController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
        if ($this->request->ajax()) {
            $data = TechnicalSpecWagon::with(['wagon_sub_type.wagon_type'])
                ->orderBy('created_at', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.technical-specification.wagon.index')->with([
            'access' => $access
        ]);
    }



    private $rule = [
        'wagon_sub_type' => 'required',
        'loading_weight' => 'required',
        'empty_weight' => 'required',
        'maximum_speed' => 'required',
        'long' => 'required',
        'width' => 'required',
        'height_from_rail' => 'required',
        'axle_load' => 'required',
        'bogie_distance' => 'required',
        'usability' => 'required',
    ];

    private $message = [
        'wagon_sub_type.required' => 'kolom jenis lokomotif wajib di isi',
        'loading_weight.required' => 'kolom berat muat wajib di isi',
        'empty_weight.required' => 'kolom berat kosong wajib di isi',
        'maximum_speed.required' => 'kolom kecepatan maksimum wajib di isi',
        'usability.required' => 'kolom kegunaan wajib di isi',
        'long.required' => 'kolom panjang wajib di isi',
        'width.required' => 'kolom lebar wajib di isi',
        'height_from_rail.required' => 'kolom tinggi dari rel wajib di isi',
        'axle_load.required' => 'kolom beban gandar wajib di isi',
        'bogie_distance.required' => 'kolom jarak pusat antar bogie wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
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
                    'wagon_sub_type_id' => $this->postField('wagon_sub_type'),
                    'loading_weight' => $this->postField('loading_weight'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height_from_rail' => $this->postField('height_from_rail'),
                    'axle_load' => $this->postField('axle_load'),
                    'boogie_distance' => $this->postField('bogie_distance'),
                    'usability' => $this->postField('usability'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                TechnicalSpecWagon::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $wagon_sub_types = WagonSubType::with(['wagon_type'])->orderBy('code', 'ASC')->get();
        return view('admin.facility-menu.technical-specification.wagon.add')->with([
            'wagon_sub_types' => $wagon_sub_types,
        ]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = TechnicalSpecWagon::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'wagon_sub_type_id' => $this->postField('wagon_sub_type'),
                    'loading_weight' => $this->postField('loading_weight'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height_from_rail' => $this->postField('height_from_rail'),
                    'axle_load' => $this->postField('axle_load'),
                    'boogie_distance' => $this->postField('bogie_distance'),
                    'usability' => $this->postField('usability'),
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $wagon_sub_types = WagonSubType::with(['wagon_type'])->orderBy('code', 'ASC')->get();
        return view('admin.facility-menu.technical-specification.wagon.edit')->with([
            'data' => $data,
            'wagon_sub_types' => $wagon_sub_types,
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
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
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
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
        return view('admin.facility-menu.technical-specification.wagon.document')->with([
            'data' => $data,
            'access' => $access
        ]);
    }

    public function image_page($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
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
        return view('admin.facility-menu.technical-specification.wagon.image')->with([
            'data' => $data,
            'access' => $access
        ]);
    }

    public function destroy_document($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            TechnicalSpecWagonDocument::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function destroy_image($id)
    {
        $access = $this->getRoleAccess(Formula::APPTechSpecWagon);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            TechnicalSpecWagonImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
