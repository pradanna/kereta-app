@extends('admin.base')

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
                text: 'Berhasil Menambahkan Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('means.facility-certification.train') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SERTIFIKASI SARANA KERETA</h1>
            <p class="mb-0">Manajemen Tambah Data Sertifikasi Sarana Kereta</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.facility-certification.train') }}">Sertifikasi
                        Sarana Kereta</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Form Sertifikasi Sarana Kereta</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('area'))
                                <div class="text-danger">
                                    {{ $errors->first('area') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="storehouse" class="form-label">Depo Induk <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="storehouse" id="storehouse" style="width: 100%;">
                            </select>
                            @if ($errors->has('storehouse'))
                                <div class="text-danger">
                                    {{ $errors->first('storehouse') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="ownership" class="form-label">Kepemilikan <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="ownership" id="ownership" style="width: 100%;">
                                <option value="PT. KAI">PT. KAI</option>
                                <option value="DJKA">DJKA</option>
                            </select>
                            @if ($errors->has('ownership'))
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
                            <label for="train_type_string" class="form-label">Jenis Kereta <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="train_type_string" name="train_type_string"
                                placeholder="Jenis Kereta">
                            @if ($errors->has('train_type_string'))
                                <div class="text-danger">
                                    {{ $errors->first('train_type_string') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="engine_type" class="form-label">Tipe Kereta <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="engine_type" id="engine_type" style="width: 100%;">
                                <option value="train">Kereta Non Penggerak</option>
                                <option value="electric-train">KRL</option>
                                <option value="diesel-train">KRD</option>
                            </select>
                            @if ($errors->has('engine_type'))
                                <div class="text-danger">
                                    {{ $errors->first('engine_type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="facility_number" class="form-label">No. Sarana (Contoh: CC2061345) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="facility_number" name="facility_number"
                                placeholder="Contoh: CC2061345">
                            @if ($errors->has('facility_number'))
                                <div class="text-danger">
                                    {{ $errors->first('facility_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="testing_number" class="form-label">No. BA Pengujian Terakhir <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="testing_number" name="testing_number"
                                placeholder="Nomor BA Pengujian">
                            @if ($errors->has('testing_number'))
                                <div class="text-danger">
                                    {{ $errors->first('testing_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_start_date" class="form-label">Mulai Dinas <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="service_start_date"
                                name="service_start_date" placeholder="yyyy">
                            @if ($errors->has('service_start_date'))
                                <div class="text-danger">
                                    {{ $errors->first('service_start_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_expired_date" class="form-label">Masa Berlaku <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="service_expired_date"
                                name="service_expired_date" placeholder="dd-mm-yyyy">
                            @if ($errors->has('service_expired_date'))
                                <div class="text-danger">
                                    {{ $errors->first('service_expired_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="description" name="description"
                                placeholder="Keterangan"></textarea>
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
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function getDataStorehouse() {
            let areaID = $('#area').val();
            let storehousePath = '{{ route('public.storehouse.by.area') }}';
            let url = storehousePath + '?area=' + areaID;
            return $.get(url)
        }

        function generateStorehouseOption() {
            let el = $('#storehouse');
            el.empty();
            let elOption = '';
            getDataStorehouse().then((response) => {
                const data = response['data'];
                $.each(data, function(k, v) {
                    elOption += '<option value="' + v['id'] + '">' + v['name'] + ' (' + v['storehouse_type']
                        ['name'] + ')</option>';
                });
            }).always(() => {
                el.append(elOption);
                $('.select2').select2({
                    width: 'resolve',
                });
            })
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });

            $('#service_start_date').datepicker({
                format: 'yyyy',
                viewMode: "years",
                minViewMode: "years"
            });

            $('#service_expired_date').datepicker({
                format: 'dd-mm-yyyy',
            });

            generateStorehouseOption();
            $('#area').on('change', function(e) {
                generateStorehouseOption();
            });

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
