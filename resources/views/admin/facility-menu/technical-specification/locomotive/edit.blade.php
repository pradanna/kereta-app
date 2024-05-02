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
                window.location.href = '{{ route('means.technical-specification.locomotive') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA LOKOMOTIF</h1>
            <p class="mb-0">Manajemen Edit Data Spesifikasi Teknis Sarana Lokomotif</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.technical-specification') }}">Spesifikasi Teknis
                        Sarana</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.technical-specification.locomotive') }}">Lokomotif</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <label for="locomotive_type" class="form-label">Jenis Lokomotif <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="locomotive_type" id="locomotive_type"
                                style="width: 100%;">
                                @foreach ($locomotive_types as $locomotive_type)
                                    <option value="{{ $locomotive_type->id }}"
                                        {{ $locomotive_type->id === $data->locomotive_type_id ? 'selected' : '' }}>
                                        {{ $locomotive_type->code }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('locomotive_type'))
                                <div class="text-danger">
                                    {{ $errors->first('locomotive_type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="empty_weight" class="form-label">Berat Kosong (Ton) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="empty_weight" name="empty_weight"
                                placeholder="Berat Kosong" value="{{ $data->empty_weight }}">
                            @if ($errors->has('empty_weight'))
                                <div class="text-danger">
                                    {{ $errors->first('empty_weight') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="house_power" class="form-label">Horse Power (HP) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="house_power" name="house_power"
                                placeholder="Horse Power" value="{{ $data->house_power }}">
                            @if ($errors->has('house_power'))
                                <div class="text-danger">
                                    {{ $errors->first('house_power') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="maximum_speed" class="form-label">Kecepatan Maksimum (Km/Jam) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="maximum_speed"
                                name="maximum_speed" placeholder="Kecepatan Maksimum (VMax)"
                                value="{{ $data->maximum_speed }}">
                            @if ($errors->has('maximum_speed'))
                                <div class="text-danger">
                                    {{ $errors->first('maximum_speed') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="fuel_consumption" class="form-label">Konsumsi BBM (Lt/Jam) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="fuel_consumption"
                                name="fuel_consumption" placeholder="Konsumsi BBM" value="{{ $data->fuel_consumption }}">
                            @if ($errors->has('fuel_consumption'))
                                <div class="text-danger">
                                    {{ $errors->first('fuel_consumption') }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <hr>
                <p style="font-size: 14px; color: #777777; font-weight: bold;">Dimensi</p>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="long" class="form-label">Panjang Lokomotif (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="long" name="long"
                                placeholder="Panjang Lokomotif" value="{{ $data->long }}">
                            @if ($errors->has('long'))
                                <div class="text-danger">
                                    {{ $errors->first('long') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="width" class="form-label">Lebar Lokomotif (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="width" name="width"
                                placeholder="Lebar Lokomotif" value="{{ $data->width }}">
                            @if ($errors->has('width'))
                                <div class="text-danger">
                                    {{ $errors->first('width') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="height" class="form-label">Tinggi Maksimum (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="height" name="height"
                                placeholder="Tinggi Maksimum" value="{{ $data->height }}">
                            @if ($errors->has('height'))
                                <div class="text-danger">
                                    {{ $errors->first('height') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="coupler_height" class="form-label">Tinggi Coupler (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="coupler_height"
                                name="coupler_height" placeholder="Tinggi Coupler" value="{{ $data->coupler_height }}">
                            @if ($errors->has('coupler_height'))
                                <div class="text-danger">
                                    {{ $errors->first('coupler_height') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="wheel_diameter" class="form-label">Diameter Roda (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="wheel_diameter"
                                name="wheel_diameter" placeholder="Diameter Roda" value="{{ $data->wheel_diameter }}">
                            @if ($errors->has('wheel_diameter'))
                                <div class="text-danger">
                                    {{ $errors->first('wheel_diameter') }}
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
                                placeholder="Keterangan">{{ $data->description }}</textarea>
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
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script>
        $(document).ready(function() {
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
