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
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA PERALATAN KHUSUS</h1>
            <p class="mb-0">Manajemen Data Dokumen Spesifikasi Teknis Sarana Peralatan Khusus</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.technical-specification') }}">Spesifikasi Teknis
                        Sarana</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('means.technical-specification.special-equipment') }}">Peralatan
                        Khusus</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Dokumen Spesifikasi Teknis Sarana Peralatan Khusus {{ $data->special_equipment_type->code }}</p>
        </div>
        <div class="isi">
            <div class="d-flex flex-wrap justify-content-center gx-3">
                @forelse($data->tech_documents as $document)
                    <div class="d-flex flex-column justify-content-center align-items-center me-1 mb-3"
                        style="width: 250px;">
                        <span class="material-symbols-outlined"
                            style="font-size: 8rem !important; color: #777777">description</span>
                        <p class="fw-bold text-truncate mb-0" style="max-width: 200px;">{{ $document->name }}</p>
                        <a target="_blank" href="{{ $document->document }}" class="btn-table-action"
                            data-id="{{ $document->id }}">Lihat</a>
                        @if ($access['is_granted_delete'])
                            <a href="#" class="btn-drop-document btn-table-action"
                                data-id="{{ $document->id }}">Hapus</a>
                        @endif
                    </div>
                @empty
                    <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                        <p class="text-center fw-bold">Tidak Ada Dokumen Terlampir</p>
                    </div>
                @endforelse
            </div>
            @if ($access['is_granted_create'])
                <hr>
                <form method="post" enctype="multipart/form-data" id="form-data">
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
            @endif
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/dropzone.min.css') }}" rel="stylesheet" />
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

            success: function(file, response) {
                $('form').append('<input type="hidden" name="files[]" value="' + file.name + '">');
                console.log(response);
                uploadedDocumentMap[file.name] = response.name
            },
        };

        function deleteEvent() {
            $('.btn-drop-document').on('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus Gambar?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        destroy(id);
                    }
                });

            })
        }

        function destroy(id) {
            let url = '{{ route('means.technical-specification.special-equipment') }}' + '/' + id + '/delete-document';
            AjaxPost(url, {}, function() {
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil Menghapus Dokumen...',
                    icon: 'success',
                    timer: 700
                }).then((r) => {
                    window.location.reload();
                })
            });
        }

        $(document).ready(function() {
            $("#document-dropzone").dropzone({
                url: path,
                maxFilesize: 32,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                autoProcessQueue: false,
                uploadMultiple: true,
                paramName: "files",

                init: function() {
                    myDropzone = this;
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
                                blockLoading(true)
                                if (myDropzone.files.length > 0) {
                                    myDropzone.processQueue();
                                } else {
                                    blockLoading(false);
                                    ErrorAlert('Error',
                                        'Harap Menambahkan Data Dokumen...')
                                }
                            }
                        });
                    });
                    this.on('successmultiple', function(file, response) {
                        blockLoading(false);
                        Swal.fire({
                            title: 'Success',
                            text: 'Berhasil Menambahkan Dokumen...',
                            icon: 'success',
                            timer: 700
                        }).then((r) => {
                            window.location.reload();
                        })
                    });

                    this.on('errormultiple', function(file, response) {
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

            deleteEvent();

        });
    </script>
@endsection
