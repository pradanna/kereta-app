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
                window.location.href = '{{ route('means.technical-specification.wagon') }}';
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
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.technical-specification') }}">Spesifikasi Teknis
                        Sarana</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.technical-specification.wagon') }}">Gerbong</a></li>
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
                            <label for="wagon_sub_type" class="form-label">Jenis Gerbong <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="wagon_sub_type" id="wagon_sub_type"
                                style="width: 100%;">
                                @foreach ($wagon_sub_types as $wagon_sub_type)
                                    <option value="{{ $wagon_sub_type->id }}">{{ $wagon_sub_type->code }}
                                        ({{ $wagon_sub_type->wagon_type->code }})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('wagon_sub_type'))
                                <div class="text-danger">
                                    {{ $errors->first('wagon_sub_type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="loading_weight" class="form-label">Berat Muat (Ton) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="loading_weight"
                                name="loading_weight" placeholder="Berat Muat">
                            @if ($errors->has('loading_weight'))
                                <div class="text-danger">
                                    {{ $errors->first('loading_weight') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="empty_weight" class="form-label">Berat Kosong (Kg) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="empty_weight" name="empty_weight"
                                placeholder="Berat Kosong">
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
                            <label for="maximum_speed" class="form-label">Kecepatan Maksimum (Km/Jam) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="maximum_speed"
                                name="maximum_speed" placeholder="Kecepatan Maksimum (VMax)">
                            @if ($errors->has('maximum_speed'))
                                <div class="text-danger">
                                    {{ $errors->first('maximum_speed') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="usability" class="form-label">Kegunaan <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" step="any" class="form-control" id="usability" name="usability"
                                placeholder="Kegunaan">
                            @if ($errors->has('usability'))
                                <div class="text-danger">
                                    {{ $errors->first('usability') }}
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
                            <label for="long" class="form-label">Panjang Total Gerbong (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="long" name="long"
                                placeholder="Panjang Total Gerbong">
                            @if ($errors->has('long'))
                                <div class="text-danger">
                                    {{ $errors->first('long') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="width" class="form-label">Lebar Gerbong (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="width" name="width"
                                placeholder="Lebar Gerbong">
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
                            <label for="height_from_rail" class="form-label">Tinggi Lantai Dari Rel (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="height_from_rail"
                                name="height_from_rail" placeholder="Tinggi Lantai Dari Rel">
                            @if ($errors->has('height_from_rail'))
                                <div class="text-danger">
                                    {{ $errors->first('height_from_rail') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="axle_load" class="form-label">Beban Gandar (Ton) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="axle_load" name="axle_load"
                                placeholder="Beban Gandar">
                            @if ($errors->has('axle_load'))
                                <div class="text-danger">
                                    {{ $errors->first('axle_load') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="bogie_distance" class="form-label">Jarak Antar Pusat Bogie (mm) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="bogie_distance"
                                name="bogie_distance" placeholder="Jarak Antar Pusat Bogie">
                            @if ($errors->has('bogie_distance'))
                                <div class="text-danger">
                                    {{ $errors->first('bogie_distance') }}
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
