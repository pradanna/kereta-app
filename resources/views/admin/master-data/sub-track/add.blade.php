@extends('admin/base')

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
                text: 'Berhasil Menambahkan Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('sub-track.service-unit') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER PETAK</h1>
            <p class="mb-0">Manajemen Tambah Data Master Petak</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master-data') }}">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sub-track.service-unit') }}">Petak</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="panel ">
        <div class="title">
            <p>Form Data Petak</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                {{--                <div class="row mb-3"> --}}
                {{--                    <div class="col-12"> --}}
                {{--                        <div class="form-group w-100"> --}}
                {{--                            <label for="track" class="form-label">Perlintasan</label> --}}
                {{--                            <select class="select2 form-control" name="track" id="track" style="width: 100%;"> --}}
                {{--                                @foreach ($tracks as $track) --}}
                {{--                                    <option value="{{ $track->id }}">{{ $track->name }} ({{ $track->code }})</option> --}}
                {{--                                @endforeach --}}
                {{--                            </select> --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                {{--                </div> --}}
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="code" class="form-label">Kode <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Kode Lintas Antara">
                            @if ($errors->has('code'))
                                <div class="text-danger">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama Petak <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Petak">
                            @if ($errors->has('name'))
                                <div class="text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
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
