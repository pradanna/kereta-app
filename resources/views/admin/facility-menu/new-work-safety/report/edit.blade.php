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
            <h1 class="h1">LAPORAN BULANAN K3L</h1>
            <p class="mb-0">Manajemen Tambah Data Laporan Bulanan K3L</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means.work-safety') }}">Keselamatan dan Kesehatan Kerja
                        (K3)</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.work-safety.report') }}">Laporan Bulanan K3L</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data" enctype="multipart/form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Tambah Data Laporan Bulanan K3L</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="date" class="form-label">Bulan <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="date" name="date"
                                placeholder="Bulan" value="{{ \Carbon\Carbon::parse($data->date)->format('F Y') }}">
                            <div class="text-danger d-none" id="error-date">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama Laporan <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Laporan" value="{{ $data->name }}">
                            <div class="text-danger" id="error-name"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="description" name="description"
                                placeholder="Keterangan">{{ $data->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label for="document-dropzone" class="form-label">Dokumen <span
                                class="text-danger ms-1">*</span></label>
                        <div class="w-100 needsclick dropzone" id="document-dropzone"></div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama rnd" id="btn-save" href="#">Simpan
                        <i class="material-symbols-outlined menu-icon ms-1 text-white">save</i>
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('/css/dropzone.min.css') }}" rel="stylesheet" />
    <style>
        .dz-error-message {
            display: none !important;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var reportPath = '{{ route('means.work-safety.report') }}';
        var path = '/{{ request()->path() }}';
        let table;
        var uploadedDocumentMap = {};
        var myDropzone;

        Dropzone.autoDiscover = false;
        Dropzone.options.documentDropzone = {

            success: function(file, response) {
                $('form').append('<input type="hidden" name="file" value="' + file.name + '">');
                console.log(response);
                uploadedDocumentMap[file.name] = response.name
            },
        };

        function setupDropzone() {
            $("#document-dropzone").dropzone({
                url: path,
                maxFilesize: 32,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                autoProcessQueue: false,
                paramName: "file",

                init: function() {
                    myDropzone = this;
                    $('#btn-save').on('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: "Konfirmasi!",
                            text: "Apakah anda yakin merubah data?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Batal',
                        }).then((result) => {
                            if (result.value) {
                                blockLoading(true);
                                if (myDropzone.files.length > 0) {
                                    myDropzone.processQueue();
                                } else {
                                    let frm = $('#form-data')[0];
                                    let f_data = new FormData(frm);
                                    $.ajax({
                                        type: "POST",
                                        enctype: 'multipart/form-data',
                                        url: path,
                                        data: f_data,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        timeout: 600000,
                                        success: function(data) {
                                            blockLoading(false);
                                            Swal.fire({
                                                title: 'Berhasil',
                                                text: 'Berhasil Menyimpan data...',
                                                icon: 'success',
                                                timer: 700
                                            }).then(() => {
                                                window.location.href =
                                                    reportPath;
                                            });
                                        },
                                        error: function(r) {
                                            let response = r.responseJSON;
                                            blockLoading(false);
                                            if (response['status'] === 422) {
                                                let data = response['data'];
                                                if (data['name'] !== undefined) {
                                                    let elName = $('#error-name');
                                                    elName.removeClass('d-none');
                                                    elName.html(data['name'][0]);
                                                }

                                                if (data['date'] !== undefined) {
                                                    let elDate = $('#error-date');
                                                    elDate.removeClass('d-none');
                                                    elDate.html(data['date'][0]);
                                                }
                                                Swal.fire({
                                                    title: 'Ooops',
                                                    text: 'Harap Mengisi Kolom Dengan Benar...',
                                                    icon: 'error',
                                                    timer: 700
                                                });
                                            } else {
                                                Swal.fire({
                                                    title: 'Ooops',
                                                    text: 'Gagal Menambahkan Data...',
                                                    icon: 'error',
                                                    timer: 700
                                                });
                                            }
                                        }
                                    })
                                }
                            }
                        });
                    });
                    this.on('success', function(file, response) {
                        blockLoading(false);
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Menambahkan Data...',
                            icon: 'success',
                            timer: 700
                        }).then(() => {
                            window.location.href = reportPath;
                        });
                    });

                    this.on('error', function(file, response) {
                        blockLoading(false);
                        if (response['status'] === 422) {
                            let data = response['data'];
                            if (data['name'] !== undefined) {
                                let elName = $('#error-name');
                                elName.removeClass('d-none');
                                elName.html(data['name'][0]);
                            }

                            if (data['date'] !== undefined) {
                                let elDate = $('#error-date');
                                elDate.removeClass('d-none');
                                elDate.html(data['date'][0]);
                            }
                            Swal.fire({
                                title: 'Ooops',
                                text: 'Harap Mengisi Kolom Dengan Benar...',
                                icon: 'error',
                                timer: 700
                            });
                        } else {
                            Swal.fire({
                                title: 'Ooops',
                                text: 'Gagal Menambahkan Data...',
                                icon: 'error',
                                timer: 700
                            });
                        }
                        console.log(response);
                    });

                    this.on('addedfile', function(file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }
                    });

                    this.on('sending', function(file, xhr, formData) {
                        // Append all form inputs to the formData Dropzone will POST
                        var data = $('#form-data').serializeArray();
                        $.each(data, function(key, el) {
                            formData.append(el.name, el.value);
                        });
                    });
                },
            });
        }

        $(document).ready(function() {
            $('.datepicker').datepicker({
                format: 'MM yyyy',
                viewMode: 'months',
                minViewMode: 'months',
                locale: 'id',
                autoclose: true,
            });
            setupDropzone();
        });
    </script>
@endsection
