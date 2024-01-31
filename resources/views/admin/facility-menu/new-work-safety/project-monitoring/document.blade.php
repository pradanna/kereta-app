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
            <h1 class="h1">MONITORING IMPLEMENTASI K3</h1>
            <p class="mb-0">Manajemen Data Monitoring Implementasi K3</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means.work-safety') }}">Keselamatan dan Kesehatan Kerja
                        (K3)</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitoring Implementasi K3</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Proyek {{ $data->project_name }}</p>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th>Nama Dokumen</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <hr>
            @if($access['is_granted_create'])
                <p>Tambah Dokumen Baru</p>
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
            @endif
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
    <link href="{{ asset('/css/dropzone.min.css') }}" rel="stylesheet"/>
    <style>
        .dz-error-message {
            display: none !important;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        let table;
        var uploadedDocumentMap = {};
        var myDropzone;
        let grantedDelete = '{{ $access['is_granted_delete'] }}';

        Dropzone.autoDiscover = false;
        Dropzone.options.documentDropzone = {

            success: function (file, response) {
                $('form').append('<input type="hidden" name="files[]" value="' + file.name + '">');
                console.log(response);
                uploadedDocumentMap[file.name] = response.name
            },
        };

        function generateTable() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.param = $('#param').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center middle-header',
                },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'middle-header',
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = data['document'];
                            let elDelete = grantedDelete === '1' ? '<a href="#" class="btn-delete btn-table-action" data-id="' + data[
                                'id'] + '">Delete</a>' : '';
                            return '<a href="' + urlEdit +
                                '" target="_blank" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Unduh</a>' + elDelete;
                        },
                        orderable: false,
                        className: 'text-center middle-header',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function (setting) {
                    deleteEvent();
                },
                dom: 'ltrip'
            });
        }

        function deleteEvent() {
            $('.btn-drop-document').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus dokumen?",
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
            let url = path + '/' + id + '/delete';
            AjaxPost(url, {}, function () {
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

        function setupDropzone() {
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
                        Swal.fire({
                            title: 'Success',
                            text: 'Berhasil Menambahkan Dokumen...',
                            icon: 'success',
                            timer: 700
                        }).then((r) => {
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
        }

        $(document).ready(function () {
            generateTable();
            setupDropzone();
        })
    </script>
@endsection
