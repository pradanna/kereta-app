@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('facility-certification') }}">Sertifikasi Sarana</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="card w-100 shadow-sm">
        <div class="card-body">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-1">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="facility_type" class="form-label">Jenis Sarana</label>
                            <select class="select2 form-control" name="facility_type" id="facility_type"
                                    style="width: 100%;">
                                @foreach($facility_types as $facility_type)
                                    <option value="{{ $facility_type->id }}">{{ $facility_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah</label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="storehouse" class="form-label">Depo Induk</label>
                            <select class="select2 form-control" name="storehouse" id="storehouse"
                                    style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="ownership" class="form-label">Kepemilikan</label>
                            <input type="text" class="form-control" id="ownership" name="ownership" placeholder="Contoh: PT. KAI">
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="facility_number" class="form-label">No. Sarana</label>
                            <input type="text" class="form-control" id="facility_number" name="facility_number" placeholder="Nomor Sarana">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="ownership" class="form-label">Kepemilikan</label>
                            <input type="text" class="form-control" id="ownership" name="ownership" placeholder="Kepemilikan">
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_start_date" class="form-label">Mulai Dinas</label>
                            <input type="text" class="form-control datepicker" id="service_start_date" name="service_start_date" placeholder="Mulai Dinas">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_expired_date" class="form-label">Masa Berlaku</label>
                            <input type="text" class="form-control datepicker" id="service_expired_date" name="service_expired_date" placeholder="Masa Berlaku">
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="testing_number" class="form-label">No. BA Pengujian</label>
                            <input type="text" class="form-control" id="testing_number" name="testing_number" placeholder="Nomor BA Pengujian">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="#" id="btn-save" class="btn btn-primary d-flex align-items-center justify-content-center">
                        <span class="material-icons-round me-1" style="font-size: 14px;">check</span>
                        Simpan
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'mm/dd/yyyy',
                startDate: '-3d'
            });
        });
    </script>
@endsection
