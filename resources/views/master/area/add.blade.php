@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('area') }}">Daerah Operasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="card w-100 shadow-sm">
        <div class="card-body">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-1">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_unit" class="form-label">Satuan Pelayanan</label>
                            <select class="select2 form-control" name="service_unit" id="service_unit"  style="width: 100%;">
                                @foreach($service_units as $service_unit)
                                    <option value="{{ $service_unit->id }}">{{ $service_unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama Daerah Operasi</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: DAOP 6 Semarang">
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" step="any" class="form-control" id="latitude" name="latitude" placeholder="Contoh: 7.1129489">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" step="any" class="form-control" id="longitude" name="longitude" placeholder="Contoh: 110.1129489">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="#" id="btn-save" class="btn btn-primary d-flex align-items-center justify-content-center">
                        <span class="material-icons-round me-1" style="font-size: 14px;">check</span>
                        Simpan
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .select2-selection {
            height: 2.4rem !important;
            line-height: 40px !important;
            border: 1px solid #ddd !important;
        }

        .select2-selection__rendered {
            height: 2.4rem !important;
            line-height: 2.4rem !important;
        }

        .select2-selection__arrow {
            height: 2.4rem !important;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select a state",
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
