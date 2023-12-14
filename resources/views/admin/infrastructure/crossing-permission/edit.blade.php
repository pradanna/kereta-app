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
                window.location.href = '{{ route('infrastructure.crossing.permission.main', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">PERMOHONAN IZIN MELINTAS REL {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Permohonan Izin Melintas Rel {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('infrastructure') }}">Prasarana</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('infrastructure.crossing.permission.main', ['service_unit_id' => $service_unit->id]) }}">Permohonan Izin Melintas Rel {{ $service_unit->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Tambah Data Safety Assessment</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="sub_track" class="form-label">Petak</label>
                            <select class="select2 form-control" name="sub_track" id="sub_track"
                                    style="width: 100%;">
                                @foreach ($sub_tracks as $sub_track)
                                    <option
                                        value="{{ $sub_track->id }}" {{ ($sub_track->id === $data->sub_track_id) ? 'selected' : '' }}>{{ $sub_track->code }}
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
                            <label for="decree_number" class="form-label">No. SK</label>
                            <input type="text" class="form-control" id="decree_number"
                                   name="decree_number" value="{{ $data->decree_number }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="decree_date" class="form-label">Tanggal SK</label>
                            <input type="text" class="form-control datepicker" id="decree_date"
                                   name="decree_date" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="intersection" class="form-label">Jenis Perpotongan / Persinggungan</label>
                            <input type="text" class="form-control" id="intersection"
                                   name="intersection" value="{{ $data->intersection }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="building_type" class="form-label">Jenis Bangunan</label>
                            <input type="text" class="form-control" id="building_type"
                                   name="building_type" value="{{ $data->building_type }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="agency" class="form-label">Badan Hukum / Instansi</label>
                            <input type="text" class="form-control" id="agency"
                                   name="agency" value="{{ $data->agency }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="expired_date" class="form-label">Tanggal Habis Masa Berlaku</label>
                            <input type="text" class="form-control datepicker" id="expired_date"
                                   name="expired_date" placeholder="dd-mm-yyyy">
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
            let decreeDateValue = '{{ $data->decree_date }}';
            let expDateValue = '{{ $data->expired_date }}';
            let decreeDate = new Date(decreeDateValue);
            let expDate = new Date(expDateValue);
            $('#decree_date').datepicker('setDate', decreeDate);
            $('#expired_date').datepicker('setDate', expDate);
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
