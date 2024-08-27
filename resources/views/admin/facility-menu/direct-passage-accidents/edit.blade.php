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
                text: 'Berhasil Menambahkan Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href =
                    '{{ route('means.direct-passage-accident.service-unit', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">PERISTIWA LUAR BIASA HEBAT (PLH) {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Tambah Data Peristiwa Luar Biasa Hebat (PLH) {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('means.direct-passage-accident.service-unit', ['service_unit_id' => $service_unit->id]) }}">Peristiwa
                        Luar Biasa Hebat (PLH) {{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Edit Data Peristiwa Luar Biasa Hebat (PLH)</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ $data->area_id === $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
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
                            <label for="track" class="form-label">Lintas <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="track" id="track" style="width: 100%;">
                                @foreach ($tracks as $track)
                                    <option value="{{ $track->id }}"
                                        {{ $data->track_id === $track->id ? 'selected' : '' }}>{{ $track->code }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('track'))
                                <div class="text-danger">
                                    {{ $errors->first('track') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="sub_track" class="form-label">Petak <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="sub_track" id="sub_track" style="width: 100%;">
                                @foreach ($sub_tracks as $sub_track)
                                    <option value="{{ $sub_track->id }}"
                                        {{ $data->sub_track_id === $sub_track->id ? 'selected' : '' }}>
                                        {{ $sub_track->code }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('sub_track'))
                                <div class="text-danger">
                                    {{ $errors->first('sub_track') }}
                                </div>
                            @endif
                        </div>
                    </div>
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
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="direct_passage" class="form-label">No. JPL</label>
                            <select class="select2 form-control" name="direct_passage" id="direct_passage"
                                style="width: 100%;">
                                <option value="">Tidak Berada Pada Jalur Perlintasan Langsung</option>
                                @foreach ($direct_passages as $direct_passage)
                                    <option value="{{ $direct_passage->id }}"
                                        {{ $data->direct_passage_id === $direct_passage->id ? 'selected' : '' }}>
                                        {{ $direct_passage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="city" class="form-label">Kabupaten / Kota <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="city" id="city" style="width: 100%;">
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ $data->city_id === $city->id ? 'selected' : '' }}>{{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('city'))
                                <div class="text-danger">
                                    {{ $errors->first('city') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="date" class="form-label">Tanggal Kejadian <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="date" name="date"
                                placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="time" class="form-label">Waktu Kejadian <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="time" class="form-control" id="time" name="time"
                                value="{{ \Carbon\Carbon::parse($data->date)->format('H:i') }}">
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
                            <label for="train_name" class="form-label">Jenis Kereta Api <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="train_name" name="train_name"
                                placeholder="Jenis Kereta Api" value="{{ $data->train_name }}">
                            @if ($errors->has('train_name'))
                                <div class="text-danger">
                                    {{ $errors->first('train_name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="accident_type" class="form-label">Jenis Laka <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="accident_type" name="accident_type"
                                placeholder="Jenis Laka" value="{{ $data->accident_type }}">
                            @if ($errors->has('accident_type'))
                                <div class="text-danger">
                                    {{ $errors->first('accident_type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="injured" class="form-label">Korban Luka-Luka <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" class="form-control" id="injured" name="injured"
                                value="{{ $data->injured }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="died" class="form-label">Korban Meninggal <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" class="form-control" id="died" name="died"
                                value="{{ $data->died }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="damaged_description" class="form-label">Kerugian</label>
                            <textarea rows="3" class="form-control" id="damaged_description" name="damaged_description">{{ $data->damaged_description }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan/Tindak Lanjut</label>
                            <textarea rows="3" class="form-control" id="description" name="description">{{ $data->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="chronology" class="form-label">Kronologi</label>
                            <textarea rows="3" class="form-control" id="chronology" name="chronology">{{ $data->chronology }}</textarea>
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
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function initializeDate() {
            let dateValue = '{{ $data->date }}';
            let date = new Date(dateValue);
            $('#date').datepicker('setDate', date);
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
