@extends('admin.base')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", 'internal server error...', "error")
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('technical-specification.locomotive') }}">Spesifikasi
                        Teknis Sarana Lokomotif</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Form Data Spesifikasi Teknis Sarana Lokomotif</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="facility_train" class="form-label">Identitas Sarana</label>
                            <select class="select2 form-control" name="facility_train"
                                    id="facility_train" style="width: 100%;">
                                @foreach ($facility_trains as $facility_train)
                                    <option
                                        value="{{ $facility_train->id }}">{{ $facility_train->facility_number }} ({{ $facility_train->train_type->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="empty_weight" class="form-label">Berat Kosong (Ton)</label>
                            <input type="number" step="any" class="form-control" id="empty_weight" name="empty_weight"
                                   placeholder="Berat Kosong">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="passenger_capacity" class="form-label">Kapasitas Penumpang</label>
                            <input type="number" step="any" class="form-control" id="passenger_capacity" name="passenger_capacity"
                                   placeholder="Kapasitas Penumpang">
                        </div>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="maximum_speed" class="form-label">Kecepatan Maksimum (Km/Jam)</label>
                            <input type="number" step="any" class="form-control" id="maximum_speed" name="maximum_speed"
                                   placeholder="Kecepatan Maksimum (VMax)">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="air_conditioner" class="form-label">Jenis AC</label>
                            <input type="text" class="form-control" id="air_conditioner"
                                   name="air_conditioner"
                                   placeholder="Jenis AC">
                        </div>
                    </div>

                </div>
                <hr>
                <p style="font-size: 14px; color: #777777; font-weight: bold;">Dimensi</p>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="long" class="form-label">Panjang Kereta (mm)</label>
                            <input type="number" step="any" class="form-control" id="long" name="long"
                                   placeholder="Panjang Kereta">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="width" class="form-label">Lebar Kereta (mm)</label>
                            <input type="number" step="any" class="form-control" id="width" name="width"
                                   placeholder="Lebar Kereta">
                        </div>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="height" class="form-label">Tinggi Kereta (mm)</label>
                            <input type="number" step="any" class="form-control" id="height" name="height"
                                   placeholder="Tinggi Kereta">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="coupler_height" class="form-label">Tinggi Alat Perangkai (mm)</label>
                            <input type="number" step="any" class="form-control" id="coupler_height" name="coupler_height"
                                   placeholder="Tinggi Alat Perangkai">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="axle_load" class="form-label">Beban Gandar (Ton)</label>
                            <input type="number" step="any" class="form-control" id="axle_load" name="axle_load"
                                   placeholder="Beban Gandar">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="spoor_width" class="form-label">Lebar Spoor (mm)</label>
                            <input type="number" step="any" class="form-control" id="spoor_width" name="spoor_width"
                                   placeholder="Lebar Spoor">
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