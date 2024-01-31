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
                window.location.href = '{{ route('user') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MANAJEMEN PENGGUNA APLIKASI</h1>
            <p class="mb-0">Manajemen Tambah Data Pengguna Aplikasi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user') }}">Pengguna Aplikasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Tambah Data Pengguna Aplikasi</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                   placeholder="Username">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="nickname" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nickname" name="nickname"
                                placeholder="Nama">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password-confirm" name="password-confirm"
                                placeholder="Konfirmasi Password">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
{{--                    <div class="col-6">--}}
{{--                        <div class="form-group w-100">--}}
{{--                            <label for="role" class="form-label">Hak Akses</label>--}}
{{--                            <select class="select2 form-control" name="role" id="role" style="width: 100%;">--}}
{{--                                <option value="admin-area">Admin Daerah Operasi (DAOP)</option>--}}
{{--                                <option value="chief-area">Kepala Daerah Operasi (DAOP)</option>--}}
{{--                                <option value="admin-service-unit">Admin Satuan Pelayanan (SATPEL)</option>--}}
{{--                                <option value="chief-service-unit">Kepala Satuan Pelayanan (SATPEL)</option>--}}
{{--                                <option value="admin-office">Admin Balai (BTP)</option>--}}
{{--                                <option value="chief-office">Kepala Balai (BTP)</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="service_unit" class="form-label">Satuan Pelayanan</label>
                            <select class="select2 form-control" name="service_unit" id="service_unit" style="width: 100%;">
                                @foreach ($service_units as $service_unit)
                                    <option value="{{ $service_unit->id }}">{{ $service_unit->name }}</option>
                                @endforeach
                            </select>
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
