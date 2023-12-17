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
                text: 'Berhasil Merubah Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('resort.service-unit', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER RESORT {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Edit Data Master Resort {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master-data') }}">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('resort') }}">Resort {{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('resort.service-unit', ['service_unit_id' => $service_unit->id]) }}">{{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Edit Data Resort</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama Resort</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Contoh: Semarang Poncol" value="{{ $data->name }}">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <div class="d-flex justify-content-end">
                        <a class="btn-utama  rnd " id="btn-save" href="#">Simpan <i
                                class="material-symbols-outlined menu-icon ms-2 text-white">save</i></a>
                    </div>
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
