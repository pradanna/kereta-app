@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('service-unit') }}">Satuan Pelayanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="card w-100 shadow-sm">
        <div class="card-body">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Satuan Pelayanan Surakarta">
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
                <div class="d-flex justify-content-end mb-3">
                    <a href="#" id="btn-save" class="btn btn-primary d-flex align-items-center justify-content-center">
                        <span class="material-icons-round me-1" style="font-size: 14px;">check</span>
                        Simpan
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
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
