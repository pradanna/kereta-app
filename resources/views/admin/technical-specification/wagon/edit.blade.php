@extends('admin.base')

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
                text: 'Berhasil Merubah Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('technical-specification.wagon') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA GERBONG</h1>
            <p class="mb-0">Manajemen Data Spesifikasi Teknis Sarana Gerbong</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('technical-specification.wagon') }}">Spesifikasi
                        Teknis Sarana Gerbong</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Form Data Spesifikasi Teknis Sarana Gerbong</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="facility_wagon" class="form-label">Identitas Sarana</label>
                            <select class="select2 form-control" name="facility_wagon"
                                    id="facility_wagon" style="width: 100%;">
                                @foreach ($facility_wagons as $facility_wagon)
                                    <option
                                        value="{{ $facility_wagon->id }}" {{ ($facility_wagon->id === $data->facility_wagon_id) ? 'selected' :'' }}>{{ $facility_wagon->facility_number }} ({{ $facility_wagon->wagon_sub_type->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="loading_weight" class="form-label">Berat Muat (Ton)</label>
                            <input type="number" step="any" class="form-control" id="loading_weight" name="loading_weight"
                                   placeholder="Berat Muat" value="{{ $data->loading_weight }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="empty_weight" class="form-label">Berat Kosong (Ton)</label>
                            <input type="number" step="any" class="form-control" id="empty_weight" name="empty_weight"
                                   placeholder="Berat Kosong" value="{{ $data->empty_weight }}">
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="maximum_speed" class="form-label">Kecepatan Maksimum (Km/Jam)</label>
                            <input type="number" step="any" class="form-control" id="maximum_speed" name="maximum_speed"
                                   placeholder="Kecepatan Maksimum (VMax)" value="{{ $data->maximum_speed }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="usability" class="form-label">Kegunaan</label>
                            <input type="text" step="any" class="form-control" id="usability" name="usability"
                                   placeholder="Kegunaan" value="{{ $data->usability }}">
                        </div>
                    </div>
                </div>
                <hr>
                <p style="font-size: 14px; color: #777777; font-weight: bold;">Dimensi</p>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="long" class="form-label">Panjang Total Gerbong (mm)</label>
                            <input type="number" step="any" class="form-control" id="long" name="long"
                                   placeholder="Panjang Total Gerbong" value="{{ $data->long }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="width" class="form-label">Lebar Gerbong (mm)</label>
                            <input type="number" step="any" class="form-control" id="width" name="width"
                                   placeholder="Lebar Gerbong" value="{{ $data->width }}">
                        </div>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="height_from_rail" class="form-label">Tinggi Lantai Dari Rel (mm)</label>
                            <input type="number" step="any" class="form-control" id="height_from_rail" name="height_from_rail"
                                   placeholder="Tinggi Lantai Dari Rel" value="{{ $data->height_from_rail }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="axle_load" class="form-label">Beban Gandar (Ton)</label>
                            <input type="number" step="any" class="form-control" id="axle_load" name="axle_load"
                                   placeholder="Beban Gandar" value="{{ $data->axle_load }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="bogie_distance" class="form-label">Jarak Antar Pusat Bogie (mm)</label>
                            <input type="number" step="any" class="form-control" id="bogie_distance" name="bogie_distance"
                                   placeholder="Jarak Antar Pusat Bogie" value="{{ $data->bogie_distance }}">
                        </div>
                    </div>

                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama rnd" id="btn-save" href="#">
                        Simpan
                        <i class="material-symbols-outlined menu-icon ms-2 text-white">save</i>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
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
