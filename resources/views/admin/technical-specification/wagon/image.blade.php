@extends('admin.base')

@section('content')
    <div class="lazy-backdrop" id="overlay-loading">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
            </div>
            <p class="text-light">Sedang Mengunggah Data Gambar....</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA GERBONG</h1>
            <p class="mb-0">Manajemen Data Gambar Spesifikasi Teknis Sarana Gerbong</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('technical-specification.wagon') }}">Spesifikasi
                        Teknis Sarana Gerbong</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->wagon_sub_type->code }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Gambar Spesifikasi Teknis Sarana Gerbong {{ $data->wagon_sub_type->code }}</p>
        </div>
        <div class="isi">

            <div class="row gx-3">
                @forelse($data->tech_images as $image)
                    <div class="col-3">
                        <div class="d-flex flex-column justify-content-center align-items-center w-100">
                            <img src="{{ asset($image->image) }}" height="100" width="100">
                        </div>
                    </div>
                @empty
                    <div class="col-12 d-flex justify-content-center align-items-center" style="height: 200px;">
                        <p class="text-center fw-bold">Tidak Ada Gambar Terlampir</p>
                    </div>
                @endforelse
            </div>
            <hr>
            <form method="post"
                  enctype="multipart/form-data"
                  id="form-data">
                @csrf
                <div class="w-100 needsclick dropzone" id="document-dropzone"></div>
            </form>
            <hr>
            <div class="d-flex justify-content-end">
                <a class="btn-utama rnd" id="btn-save" href="#">
                    Upload
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_upload</i>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/dropzone.min.css') }}" rel="stylesheet"/>
    <style>
        .dz-error-message {
            display: none !important;
        }
    </style>

@endsection

@section('js')
    <script src="{{ asset('/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>
        const path = '/{{ request()->path() }}';
        var uploadedDocumentMap = {};
        var myDropzone;

        Dropzone.autoDiscover = false;
        Dropzone.options.documentDropzone = {

            success: function (file, response) {
                $('form').append('<input type="hidden" name="files[]" value="' + file.name + '">');
                console.log(response);
                uploadedDocumentMap[file.name] = response.name
            },
        };

        $(document).ready(function () {
            $("#document-dropzone").dropzone({
                url: path,
                maxFilesize: 2,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                autoProcessQueue: false,
                uploadMultiple: true,
                paramName: "files",

                init: function () {
                    myDropzone = this;
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
                                blockLoading(true)
                                if (myDropzone.files.length > 0) {
                                    myDropzone.processQueue();
                                } else {
                                    blockLoading(false);
                                    ErrorAlert('Error', 'Harap Menambahkan Data Gambar...')
                                }
                            }
                        });
                    });
                    this.on('successmultiple', function (file, response) {
                        blockLoading(false);
                        SuccessAlert('Berhasil', 'Berhasil Menambahkan Data Gambar...').then((r) => {
                            window.location.reload();
                        })
                    });

                    this.on('errormultiple', function (file, response) {
                        blockLoading(false);
                        ErrorAlert('Error', 'Terjadi Kesalahan Server...');
                        console.log(response);
                    });
                },
            });


        });
    </script>
@endsection
