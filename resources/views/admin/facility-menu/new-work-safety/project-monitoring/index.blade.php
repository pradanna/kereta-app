@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MONITORING IMPLEMENTASI K3</h1>
            <p class="mb-0">Manajemen Data Monitoring Implementasi K3</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.work-safety') }}">Keselamatan dan Kesehatan Kerja
                        (K3)</a></li>
                <li class="breadcrumb-item active" aria-current="page">Monitoring Implementasi K3</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="param" class="form-label d-none">Param</label>
                            <input type="text" class="form-control" id="param" name="param"
                                   placeholder="Cari Nama Proyek, Lokasi atau Konsultan">
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#" style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Implementasi K3</p>
            <div class="d-flex align-item-center">
                <a class="btn-utama sml rnd me-2"
                   href="{{ route('means.work-safety.project-monitoring.add') }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
                <a class="btn-success sml rnd" href="#" id="btn-export"
                   target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="18%">Nama Proyek</th>
                    <th width="15%" class="text-center">Konsultan</th>
                    <th>Lokasi</th>
                    <th width="8%" class="text-center">Dokumen</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-detail-monitoring" tabindex="-1" aria-labelledby="modal-detail-certification"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Monitoring
                        Implementasi K3</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="project_name" class="form-label">Nama Proyek <span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" id="project_name"
                                       name="project_name"
                                       placeholder="Nama Proyek" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="consultant" class="form-label">Penyedia Jasa Konsultan <span
                                        class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" id="consultant"
                                       name="consultant"
                                       placeholder="Penyedia Jasa Konsultan" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="location" class="form-label">Lokasi Pekerjaan <span
                                        class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" id="location"
                                       name="location"
                                       placeholder="Lokasi Pekerjaan" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="description"
                                          name="description"
                                          placeholder="Keterangan" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        let table;
        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-monitoring'));

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
                        data: 'project_name',
                        name: 'project_name',
                        className: 'middle-header',
                    },
                    {
                        data: 'consultant',
                        name: 'consultant',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'location',
                        name: 'location',
                        className: 'middle-header',
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlDocument = path + '/' + data['id'] + '/dokumen';
                            return '<a href="' + urlDocument + '" class="btn-document me-2 btn-table-action" data-id="' + data[
                                'id'] + '">Lihat</a>';
                        },
                        orderable: false,
                        className: 'text-center middle-header',
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data[
                                    'id'] + '">Detail</a>' +
                                '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false,
                        className: 'text-center middle-header',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
                dom: 'ltrip'
            });
        }

        function deleteEvent() {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus data?",
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
                SuccessAlert('Success', 'Berhasil Menghapus Data...').then(() => {
                    table.ajax.reload();
                });
            });
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                detailHandler(id)
            });
        }

        async function detailHandler(id) {
            try {
                let url = path + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let project_name = data['project_name'];
                let consultant = data['consultant'];
                let location = data['location'];
                let description = data['description'];
                $('#project_name').val(project_name);
                $('#consultant').val(consultant);
                $('#location').val(location);
                $('#description').val(description);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }

        $(document).ready(function () {
            generateTable();

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });
        })
    </script>
@endsection
