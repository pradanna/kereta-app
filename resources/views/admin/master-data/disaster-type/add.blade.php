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
                window.location.href = '{{ route('disaster-type') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER JENIS RAWAN BENCANA</h1>
            <p class="mb-0">Manajemen Tambah Data Master Jenis Rawan Bencana</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master-data') }}">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('disaster-type') }}">Jenis Rawan Bencana</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="panel ">
        <div class="title">
            <p>Form Data Jenis Rawan Bencana</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-1">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Nama Jenis Rawan Bencana" required>
                        </div>
                    </div>
                </div>
{{--                <div class="row mb-1">--}}
{{--                    <div class="col-6">--}}
{{--                        <div class="w-100">--}}
{{--                            <label for="latitude" class="form-label">Latitude</label>--}}
{{--                            <input type="number" step="any" class="form-control" id="latitude" name="latitude"--}}
{{--                                   placeholder="Contoh: 7.1129489">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-6">--}}
{{--                        <div class="w-100">--}}
{{--                            <label for="longitude" class="form-label">Longitude</label>--}}
{{--                            <input type="number" step="any" class="form-control" id="longitude" name="longitude"--}}
{{--                                   placeholder="Contoh: 110.1129489">--}}
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
