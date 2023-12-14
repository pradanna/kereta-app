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
                window.location.href = '{{ route('infrastructure.train.bridges.main', ['service_unit_id' => $service_unit->id]) }}';
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
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <label for="sub_track" class="form-label">Petak</label>
                            <select class="select2 form-control" name="sub_track" id="sub_track"
                                    style="width: 100%;">
                                @foreach ($sub_tracks as $sub_track)
                                    <option value="{{ $sub_track->id }}" {{ ($sub_track->id === $data->sub_track_id) ? 'selected' : '' }}>{{ $sub_track->code }}
                                        ({{ $sub_track->track->code }} {{ $sub_track->track->area->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="stakes" class="form-label">KM/HM</label>
                            <input type="text" class="form-control" id="stakes" name="stakes"
                                   placeholder="KM/HM" value="{{ $data->stakes }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="corridor" class="form-label">Koridor</label>
                            <input type="text" class="form-control" id="corridor"
                                   name="corridor" value="{{ $data->corridor }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="reference_number" class="form-label">No. BH</label>
                            <input type="text" class="form-control" id="reference_number"
                                   name="reference_number" value="{{ $data->reference_number }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="building_type" class="form-label">Jenis Bangunan</label>
                            <input type="text" class="form-control" id="building_type"
                                   name="building_type" value="{{ $data->building_type }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="span" class="form-label">Bentang</label>
                            <input type="text" class="form-control" id="span"
                                   name="span" value="{{ $data->span }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="installed_date" class="form-label">Di Pasang</label>
                            <input type="text" class="form-control datepicker" id="installed_date"
                                   name="installed_date" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="replaced_date" class="form-label">Di Ganti</label>
                            <input type="text" class="form-control datepicker" id="replaced_date"
                                   name="replaced_date" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="strengthened_date" class="form-label">Di Perkuat</label>
                            <input type="text" class="form-control datepicker" id="strengthened_date"
                                   name="strengthened_date" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="bridge_type" class="form-label">Jembatan</label>
                            <input type="text" class="form-control" id="bridge_type"
                                   name="bridge_type" value="{{ $data->bridge_type }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <div class="w-100">
                            <label for="volume" class="form-label">Volume Andas (Buah)</label>
                            <input type="number" step="any" class="form-control" id="volume"
                                   name="volume" value="{{ $data->volume }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="w-100">
                            <label for="bearing" class="form-label">Jumlah Bantalan (Buah)</label>
                            <input type="number" step="any" class="form-control" id="bearing"
                                   name="bearing" value="{{ $data->bearing }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="w-100">
                            <label for="bolt" class="form-label">Jumlah Baut (Buah)</label>
                            <input type="number" step="any" class="form-control" id="bolt"
                                   name="bolt" value="{{ $data->bolt }}">
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
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var path = '/{{ request()->path() }}';

        function initializeDate() {
            let installedDateValue = '{{ $data->installed_date }}';
            let replacedDateValue = '{{ $data->replaced_date }}';
            let strengthenedDateValue = '{{ $data->strengthened_date }}';
            let installedDate = new Date(installedDateValue);
            let replacedDate = new Date(replacedDateValue);
            let strengthenedDate = new Date(strengthenedDateValue);
            $('#installed_date').datepicker('setDate', installedDate);
            $('#replaced_date').datepicker('setDate', replacedDate);
            $('#strengthened_date').datepicker('setDate', strengthenedDate);
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
            });
            initializeDate();
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
