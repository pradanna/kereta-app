@extends('admin.base')

@section('content')
    <div class="lazy-backdrop" id="overlay-loading">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
            </div>
            <p class="text-light">Sedang Mengunggah Data Dokumen....</p>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA KERETA</h1>
            <p class="mb-0">Manajemen Data Dokumen Spesifikasi Teknis Sarana Kereta</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('technical-specification.train') }}">Spesifikasi
                        Teknis Sarana Kereta</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->train_type->code }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Dokumen Spesifikasi Teknis Sarana Kereta {{ $data->train_type->code }}</p>
        </div>
        <div class="isi">
            <div class="d-flex flex-wrap justify-content-center gx-3">
                @forelse($data->tech_documents as $document)
                    <div class="d-flex flex-column justify-content-center align-items-center me-1 mb-3" style="width: 250px;">
                        <img src="{{ asset('/images/local/logo-google.png') }}" alt="document-image" height="200" width="200" style="object-fit: cover;">
                        <p class="fw-bold text-truncate" style="max-width: 200px;">{{ $document->name }}</p>
                        <a href="#" class="btn-drop-image btn-table-action" data-id="{{ $document->id }}">Hapus</a>
                    </div>
                @empty
                    <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                        <p class="text-center fw-bold">Tidak Ada Dokumen Terlampir</p>
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
                                    ErrorAlert('Error', 'Harap Menambahkan Data Dokumen...')
                                }
                            }
                        });
                    });
                    this.on('successmultiple', function (file, response) {
                        blockLoading(false);
                        SuccessAlert('Berhasil', 'Berhasil Menambahkan Data Dokumen...').then((r) => {
                            window.location.reload();
                        })
                    });

                    this.on('errormultiple', function (file, response) {
                        blockLoading(false);
                        ErrorAlert('Error', 'Terjadi Kesalahan Server...');
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

