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
                window.location.href =
                    '{{ route('infrastructure.train.bridges.main', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">JEMBATAN KERETA API {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Jembatan Kereta Api {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('infrastructure') }}">Prasarana</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('infrastructure.train.bridges.main', ['service_unit_id' => $service_unit->id]) }}">Jembatan
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
                            <label for="track" class="form-label">Lintas <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="track" id="track" style="width: 100%;">
                                @foreach ($tracks as $track)
                                    <option value="{{ $track->id }}">{{ $track->code }}</option>
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
                                    <option value="{{ $sub_track->id }}">{{ $sub_track->code }}
                                    </option>
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
                            <input type="text" class="form-control" id="stakes" name="stakes" placeholder="KM/HM">
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
                        <div class="w-100">
                            <label for="corridor" class="form-label">Koridor <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="corridor" name="corridor" placeholder="Koridor">
                            @if ($errors->has('corridor'))
                                <div class="text-danger">
                                    {{ $errors->first('corridor') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="reference_number" class="form-label">No. BH <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number"
                                placeholder="No. BH">
                            @if ($errors->has('reference_number'))
                                <div class="text-danger">
                                    {{ $errors->first('reference_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="building_type" class="form-label">Jenis Bangunan <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="building_type" name="building_type"
                                placeholder="Jenis Bangunan">
                            @if ($errors->has('reference_number'))
                                <div class="text-danger">
                                    {{ $errors->first('reference_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="span" class="form-label">Bentang <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="span" name="span"
                                placeholder="Bentang">
                            @if ($errors->has('span'))
                                <div class="text-danger">
                                    {{ $errors->first('span') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="installed_date" class="form-label">Di Pasang <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="installed_date"
                                name="installed_date" placeholder="dd-mm-yyyy"
                                value="{{ \Carbon\Carbon::now()->format('Y') }}">
                            @if ($errors->has('installed_date'))
                                <div class="text-danger">
                                    {{ $errors->first('installed_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="replaced_date" class="form-label">Di Ganti <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="replaced_date"
                                name="replaced_date" placeholder="dd-mm-yyyy"
                                value="{{ \Carbon\Carbon::now()->format('Y') }}">
                            @if ($errors->has('installed_date'))
                                <div class="text-danger">
                                    {{ $errors->first('installed_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="strengthened_date" class="form-label">Di Perkuat <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="strengthened_date"
                                name="strengthened_date" placeholder="dd-mm-yyyy"
                                value="{{ \Carbon\Carbon::now()->format('Y') }}">
                            @if ($errors->has('strengthened_date'))
                                <div class="text-danger">
                                    {{ $errors->first('strengthened_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="bridge_type" class="form-label">Jembatan <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="bridge_type" name="bridge_type"
                                placeholder="Jembatan">
                            @if ($errors->has('bridge_type'))
                                <div class="text-danger">
                                    {{ $errors->first('bridge_type') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="w-100">
                            <label for="volume" class="form-label">Volume Andas (Buah) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="volume" name="volume"
                                value="0">
                            @if ($errors->has('volume'))
                                <div class="text-danger">
                                    {{ $errors->first('volume') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="w-100">
                            <label for="bearing" class="form-label">Jumlah Bantalan (Buah) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="bearing" name="bearing"
                                value="0">
                            @if ($errors->has('bearing'))
                                <div class="text-danger">
                                    {{ $errors->first('bearing') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="w-100">
                            <label for="bolt" class="form-label">Jumlah Baut (Buah) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="bolt" name="bolt"
                                value="0">
                            @if ($errors->has('bolt'))
                                <div class="text-danger">
                                    {{ $errors->first('bolt') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" id="description" name="description" placeholder="Keterangan"></textarea>
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
                format: 'yyyy',
                viewMode: 'years',
                minViewMode: 'years',
                locale: 'id',
                autoclose: true,
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
