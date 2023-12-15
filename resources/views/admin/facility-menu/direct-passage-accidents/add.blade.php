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
                window.location.href = '{{ route('means.direct-passage-accident.service-unit', ['service_unit_id' => $service_unit->id]) }}';
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
                <li class="breadcrumb-item"><a href="{{ route('means.direct-passage-accident.service-unit', ['service_unit_id' => $service_unit->id]) }}">Peristiwa Luar Biasa Hebat (PLH) {{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Tambah Data Peristiwa Luar Biasa Hebat (PLH)</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="direct_passage" class="form-label">No. JPL</label>
                            <select class="select2 form-control" name="direct_passage" id="direct_passage"
                                    style="width: 100%;">
                                @foreach ($direct_passages as $direct_passage)
                                    <option value="{{ $direct_passage->id }}">{{ $direct_passage->name }} ({{ $direct_passage->stakes }}) ({{ $direct_passage->sub_track->code }}) ({{ $direct_passage->sub_track->track->code }}) ({{ $direct_passage->sub_track->track->area->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="date" class="form-label">Tanggal Kejadian</label>
                            <input type="text" class="form-control datepicker" id="date"
                                   name="date" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="time" class="form-label">Waktu Kejadian</label>
                            <input type="time" class="form-control" id="time"
                                   name="time">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="train_name" class="form-label">Jenis Kereta Api</label>
                            <input type="text" step="any" class="form-control" id="train_name"
                                   name="train_name">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="accident_type" class="form-label">Jenis Laka</label>
                            <select class="select2 form-control" name="accident_type" id="accident_type"
                                    style="width: 100%;">
                                    <option value="KA Tertemper Kendaraan">KA Tertemper Kendaraan</option>
                                    <option value="KA Tertemper Orang">KA Tertemper Orang</option>
                                    <option value="KA Dengan KA">KA Dengan KA</option>
                                    <option value="KA Terguling">KA Terguling</option>
                                    <option value="Bencana Lain">Bencana Lain</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="injured" class="form-label">Korban Luka-Luka</label>
                            <input type="number" class="form-control" id="injured" name="injured" value="0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="died" class="form-label">Korban Meninggal Dunia</label>
                            <input type="number" class="form-control" id="died" name="died" value="0">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="damaged_description" class="form-label">Kerugian</label>
                            <textarea rows="3" class="form-control" id="damaged_description" name="damaged_description"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan/Tindak Lanjut</label>
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
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
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
