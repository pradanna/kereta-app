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
                text: 'Berhasil Merubah Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href =
                    '{{ route('traffic.railway-station.main', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">STASIUN KERETA API {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Stasiun Kereta Api {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('traffic') }}">Lalu Lintas</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('traffic.railway-station.main', ['service_unit_id' => $service_unit->id]) }}">Stasiun
                        Kereta Api {{ $service_unit->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Tambah Data Jembatan Kereta Api</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah (Daerah Operasi) <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ $area->id === $data->area_id ? 'selected' : '' }}>{{ $area->name }}
                                    </option>
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
                            <label for="district" class="form-label">Kecamatan <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="district" id="district" style="width: 100%;">
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ $district->id === $data->district_id ? 'selected' : '' }}>
                                        {{ $district->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('district'))
                                <div class="text-danger">
                                    {{ $errors->first('district') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama Stasiun <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $data->name }}">
                            @if ($errors->has('name'))
                                <div class="text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="nickname" class="form-label">Singkatan Stasiun <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="nickname" name="nickname"
                                value="{{ $data->nickname }}">
                            @if ($errors->has('nickname'))
                                <div class="text-danger">
                                    {{ $errors->first('nickname') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="stakes" class="form-label">KM/HM <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="stakes" name="stakes" placeholder="KM/HM"
                                value="{{ $data->stakes }}">
                            @if ($errors->has('stakes'))
                                <div class="text-danger">
                                    {{ $errors->first('stakes') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="height" class="form-label">Ketinggian (mdpl) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="height" name="height"
                                value="{{ $data->height }}">
                            @if ($errors->has('height'))
                                <div class="text-danger">
                                    {{ $errors->first('height') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="latitude" class="form-label">Latitude <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="latitude" name="latitude"
                                placeholder="Contoh: 7.1129489" value="{{ $data->latitude }}">
                            @if ($errors->has('latitude'))
                                <div class="text-danger">
                                    {{ $errors->first('latitude') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="longitude" class="form-label">Longitude <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="longitude" name="longitude"
                                placeholder="Contoh: 110.1129489" value="{{ $data->longitude }}">
                            @if ($errors->has('longitude'))
                                <div class="text-danger">
                                    {{ $errors->first('longitude') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="type" class="form-label">Jenis Stasiun <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="type" name="type"
                                value="{{ $data->type }}">
                            @if ($errors->has('type'))
                                <div class="text-danger">
                                    {{ $errors->first('type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="status" class="form-label">Status <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="status" id="status" style="width: 100%;">
                                <option value="aktif" {{ 'aktif' === $data->status ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak aktif" {{ 'tidak aktif' === $data->status ? 'selected' : '' }}>
                                    Tidak Aktif</option>
                            </select>
                            @if ($errors->has('status'))
                                <div class="text-danger">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="station_class" class="form-label">Kelas Stasiun <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="station_class" id="station_class"
                                style="width: 100%;">
                                <option value="besar" {{ 'besar' === $data->station_class ? 'selected' : '' }}>Besar
                                </option>
                                <option value="sedang" {{ 'sedang' === $data->station_class ? 'selected' : '' }}>Sedang
                                </option>
                                <option value="kecil" {{ 'kecil' === $data->station_class ? 'selected' : '' }}>Kecil
                                </option>
                            </select>
                            @if ($errors->has('station_class'))
                                <div class="text-danger">
                                    {{ $errors->first('station_class') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" id="description" name="description" placeholder="Keterangan">{{ $data->description }}</textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama rnd" id="btn-save" href="#">Simpan
                        <i class="material-symbols-outlined menu-icon ms-1 text-white">save</i>
                    </a>
                </div>
            </div>
        </div>
    </form>
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
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
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
