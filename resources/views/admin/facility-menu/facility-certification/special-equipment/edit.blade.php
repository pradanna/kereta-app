@extends('admin/base')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", 'internal server error...', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('validator'))
        <script>
            Swal.fire("Ooops", '{{ \Illuminate\Support\Facades\Session::get('validator') }}', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: 'Berhasil Merubah Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('means.facility-certification.special-equipment') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SERTIFIKASI SARANA PERALATAN KHUSUS</h1>
            <p class="mb-0">Manajemen Edit Data Sertifikasi Sarana Peralatan Khusus</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.facility-certification.special-equipment') }}">Sertifikasi
                        Sarana Peralatan Khusus</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Form Sertifikasi Sarana Peralatan Khusus</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ ($area->id === $data->area_id) ? 'selected' :'' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('area'))
                                <div class="text-danger">
                                    {{ $errors->first('area') }}
                                </div>
                            @endif
                        </div>
                    </div>
{{--                    <div class="col-6">--}}
{{--                        <div class="form-group w-100">--}}
{{--                            <label for="special_equipment_type" class="form-label">Jenis Sarana</label>--}}
{{--                            <select class="select2 form-control" name="special_equipment_type" id="special_equipment_type"--}}
{{--                                style="width: 100%;">--}}
{{--                                @foreach ($special_equipment_types as $special_equipment_type)--}}
{{--                                    <option value="{{ $special_equipment_type->id }}" {{ ($special_equipment_type->id === $data->special_equipment_type_id) ? 'selected' :'' }}>{{ $special_equipment_type->code }}--}}
{{--                                        ({{ $special_equipment_type->name }})</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="new_facility_number" class="form-label">No. Sarana Baru <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="new_facility_number" name="new_facility_number"
                                placeholder="Nomor Sarana Baru" value="{{ $data->new_facility_number }}">
                            @if($errors->has('new_facility_number'))
                                <div class="text-danger">
                                    {{ $errors->first('new_facility_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="old_facility_number" class="form-label">No. Sarana Lama <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="old_facility_number" name="old_facility_number"
                                placeholder="Nomor Sarana Lama" value="{{ $data->old_facility_number }}">
                            @if($errors->has('old_facility_number'))
                                <div class="text-danger">
                                    {{ $errors->first('old_facility_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="testing_number" class="form-label">No. BA Pengujian <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="testing_number" name="testing_number"
                                placeholder="Nomor BA Pengujian" value="{{ $data->testing_number }}">
                            @if($errors->has('testing_number'))
                                <div class="text-danger">
                                    {{ $errors->first('testing_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="ownership" class="form-label">Kepemilikan <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="ownership" id="ownership"
                                    style="width: 100%;">
                                <option value="PT. KAI" {{ ($data->ownership === 'PT. KAI') ? 'selected' : '' }}>PT. KAI</option>
                                <option value="DJKA" {{ ($data->ownership === 'DJKA') ? 'selected' : '' }}>DJKA</option>
                            </select>
                            @if($errors->has('ownership'))
                                <div class="text-danger">
                                    {{ $errors->first('ownership') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_expired_date" class="form-label">Masa Berlaku <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="service_expired_date"
                                name="service_expired_date" placeholder="dd-mm-yyyy">
                            @if($errors->has('service_expired_date'))
                                <div class="text-danger">
                                    {{ $errors->first('service_expired_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control"  style="font-size: 0.8rem" id="description" name="description"
                                      placeholder="Keterangan">{{ $data->description }}</textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama  rnd " id="btn-save" href="#">Simpan <i
                            class="material-symbols-outlined menu-icon ms-2 text-white">save</i></a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function initializeDate() {
            let expDateValue = '{{ $data->service_expired_date }}';
            let expDate = new Date(expDateValue);
            $('#service_expired_date').datepicker('setDate', expDate);
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
            });

            initializeDate();

            $('#btn-save').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menyimpan data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        $('#form-data').submit()
                    }
                });
            });

        });
    </script>
@endsection
