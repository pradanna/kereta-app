@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA LOKOMOTIF</h1>
            <p class="mb-0">Manajemen Data Dokumen Spesifikasi Teknis Sarana Lokomotif</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('technical-specification.locomotive') }}">Spesifikasi
                        Teknis Sarana Lokomotif</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->locomotive_type->code }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Form Dokumen Spesifikasi Teknis Sarana Lokomotif {{ $data->locomotive_type->code }}</p>
        </div>
        <div class="isi">
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
                                if (myDropzone.files.length > 0) {
                                    myDropzone.processQueue();
                                }
                            }
                        });
                    });
                    this.on('successmultiple', function (file, response) {
                        console.log(response)
                    });

                    this.on('errormultiple', function (file, response) {
                        console.log(response);
                    });
                },

                // removedfile: function (file) {
                //     file.previewElement.remove()
                //     var name = ''
                //     if (typeof file.file_name !== 'undefined') {
                //         name = file.file_name
                //     } else {
                //         name = uploadedDocumentMap[file.name]
                //     }
                //     $('form').find('input[name="document[]"][value="' + name + '"]').remove()
                // },
            });


        });
    </script>
@endsection

