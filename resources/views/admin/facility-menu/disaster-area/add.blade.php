@extends('admin/base')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", 'internal server error...', "error")
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
                window.location.href = '{{ route('means.disaster-area.service-unit', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">DAERAH RAWAN BENCANA {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Tambah Data Daerah Rawan Bencana {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.disaster-area') }}">Daerah Rawan Bencana {{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Tambah Data Daerah Rawan Bencana</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="resort" class="form-label">Resort</label>
                            <select class="select2 form-control" name="resort" id="resort"
                                    style="width: 100%;">
                                @foreach ($resorts as $resort)
                                    <option value="{{ $resort->id }}">{{ $resort->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="sub_track" class="form-label">Petak</label>
                            <select class="select2 form-control" name="sub_track" id="sub_track"
                                    style="width: 100%;">
                                @foreach ($sub_tracks as $sub_track)
                                    <option value="{{ $sub_track->id }}">{{ $sub_track->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="location_type" class="form-label">Lokasi</label>
                            <select class="select2 form-control" name="location_type" id="location_type"
                                    style="width: 100%;">
                                <option value="0">Jalan Rel</option>
                                <option value="1">Jembatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="disaster_type" class="form-label">Jenis Rawan</label>
                            <select class="select2 form-control" name="disaster_type" id="disaster_type"
                                    style="width: 100%;">
                                @foreach ($disaster_types as $disaster_type)
                                    <option value="{{ $disaster_type->id }}">{{ $disaster_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="block" class="form-label">KM</label>
                            <input type="text" step="any" class="form-control" id="block"
                                   name="block"
                                   placeholder="KM">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="lane" class="form-label">Jalur</label>
                            <input type="text" step="any" class="form-control" id="lane"
                                   name="lane"
                                   placeholder="Jalur">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" step="any" class="form-control" id="latitude" name="latitude"
                                   placeholder="Contoh: 7.1129489">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" step="any" class="form-control" id="longitude" name="longitude"
                                   placeholder="Contoh: 110.1129489">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="handling" class="form-label">Penanganan</label>
                            <textarea rows="3" class="form-control" id="handling" name="handling"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" id="description" name="description"></textarea>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script>

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            $('#btn-save').on('click', function (e) {
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
