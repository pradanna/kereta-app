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
                window.location.href = '{{ route('locomotive-type') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="page-title-container">
            <h1 class="h1">MASTER JENIS LOKOMOTIF</h1>
            <p class="mb-0">Manajemen Edit Data Master Jenis Lokomotif</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master-data') }}">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('locomotive-type') }}">Jenis Lokomotif</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <label for="code" class="form-label">Kode <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="code" name="code"
                                   placeholder="Kode Jenis Lokomotif" value="{{ $data->code }}">
                            @if($errors->has('code'))
                                <div class="text-danger">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Nama Jenis Lokomotif" value="{{ $data->name }}">
                            @if($errors->has('name'))
                                <div class="text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
{{--                <div class="row mb-1">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="form-group w-100">--}}
{{--                            <label for="type" class="form-label">Tipe</label>--}}
{{--                            <select class="form-control" name="type" id="type">--}}
{{--                                <option value="general-electric">General Electric</option>--}}
{{--                                <option value="general-motor">General Motor</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
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
