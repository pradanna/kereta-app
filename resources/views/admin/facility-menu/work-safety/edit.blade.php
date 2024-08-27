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
                window.location.href = '{{ route('means.work-safety') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MANAJEMEN KESELAMATAN DAN KESEHATAN KERJA</h1>
            <p class="mb-0">Manajemen Tambah Data Kesalamatan Dan Kesehatan Kerja</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.work-safety') }}">Kesalamatan Dan Kesehatan Kerja</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Tambah Data Kesalamatan Dan Kesehatan Kerja</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="work_unit" class="form-label">Unit Kerja</label>
                            <input type="text" class="form-control" id="work_unit" name="work_unit"
                                value="{{ $data->work_unit }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="supervision_consultant" class="form-label">Konsultan Supervisi</label>
                            <input type="text" class="form-control" id="supervision_consultant"
                                name="supervision_consultant" value="{{ $data->supervision_consultant }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="contractor" class="form-label">Kontraktor</label>
                            <input type="text" class="form-control" id="contractor" name="contractor"
                                value="{{ $data->contractor }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="work_package" class="form-label">Paket Pekerjaan</label>
                            <input type="text" class="form-control" id="work_package" name="work_package"
                                value="{{ $data->work_package }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="period" class="form-label">Periode</label>
                            <input type="number" class="form-control" id="period" name="period"
                                value="{{ $data->period }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="performance" class="form-label">Kinerja</label>
                            <input type="text" class="form-control" id="performance" name="performance"
                                value="{{ $data->performance }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" id="description" name="description">{{ $data->description }}</textarea>
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
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
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
