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
                text: 'Berhasil Menambahkan Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('technical-specification.locomotive') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA LOKOMOTIF</h1>
            <p class="mb-0">Manajemen Tambah Data Spesifikasi Teknis Sarana Lokomotif</p>
        </div>
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
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="facility_locomotive" class="form-label">Identitas Sarana</label>
                            <select class="select2 form-control" name="facility_locomotive"
                                    id="facility_locomotive" style="width: 100%;">
                                @foreach ($facility_locomotives as $facility_locomotive)
                                    <option
                                        value="{{ $facility_locomotive->id }}">{{ $facility_locomotive->facility_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="empty_weight" class="form-label">Berat Kosong (Ton)</label>
                            <input type="number" step="any" class="form-control" id="empty_weight" name="empty_weight"
                                   placeholder="Berat Kosong">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="house_power" class="form-label">Horse Power (HP)</label>
                            <input type="number" step="any" class="form-control" id="house_power" name="house_power"
                                   placeholder="Horse Power">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="maximum_speed" class="form-label">Kecepatan Maksimum (Km/Jam)</label>
                            <input type="number" step="any" class="form-control" id="maximum_speed" name="maximum_speed"
                                   placeholder="Kecepatan Maksimum (VMax)">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="fuel_consumption" class="form-label">Konsumsi BBM (Lt/Jam)</label>
                            <input type="number" step="any" class="form-control" id="fuel_consumption"
                                   name="fuel_consumption"
                                   placeholder="Konsumsi BBM">
                        </div>
                    </div>

                </div>
                <hr>
                <p style="font-size: 14px; color: #777777; font-weight: bold;">Dimensi</p>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="long" class="form-label">Panjang Lokomotif (mm)</label>
                            <input type="number" step="any" class="form-control" id="long" name="long"
                                   placeholder="Panjang Lokomotif">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="width" class="form-label">Lebar Lokomotif (mm)</label>
                            <input type="number" step="any" class="form-control" id="width" name="width"
                                   placeholder="Lebar Lokomotif">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="height" class="form-label">Tinggi Maksimum (mm)</label>
                            <input type="number" step="any" class="form-control" id="height" name="height"
                                   placeholder="Tinggi Maksimum">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="coupler_height" class="form-label">Tinggi Coupler (mm)</label>
                            <input type="number" step="any" class="form-control" id="coupler_height" name="coupler_height"
                                   placeholder="Tinggi Coupler">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="wheel_diameter" class="form-label">Diameter Roda (mm)</label>
                            <input type="number" step="any" class="form-control" id="wheel_diameter" name="wheel_diameter"
                                   placeholder="Diameter Roda">
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
