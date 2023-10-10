@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Jenis Lokomotif</li>
            </ol>
        </nav>
    </div>
    <div class="panel ">
        <div class="title">
            <p>Form Data Jenis Lokomotif</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-1">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="code" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="code" name="code"
                                   placeholder="Kode Jenis Lokomotif">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Nama Jenis Lokomotif">
                        </div>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="type" class="form-label">Tipe</label>
                            <select class="form-control" name="type" id="type">
                                <option value="general-electric">General Electric</option>
                                <option value="general-motor">General Motor</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama  rnd " id="btn-save" href="#">Simpan <i
                            class="material-symbols-outlined menu-icon ms-2 text-white">save</i></a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
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
