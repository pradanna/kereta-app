@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA GERBONG</h1>
            <p class="mb-0">Manajemen Data Spesifikasi Teknis Sarana Gerbong</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Spesifikasi Teknis Sarana Gerbong</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Spesifikasi Teknis Sarana Gerbong</p>
            <a class="btn-utama sml rnd " href="{{ route('technical-specification.wagon.add') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="middle-header">Jenis Gerbong</th>
                    <th class="text-center middle-header" width="12%">Spesifikasi Umum</th>
                    <th class="text-center middle-header" width="12%">Dokumen</th>
                    <th class="text-center middle-header" width="12%">Gambar</th>
{{--                    <th class="text-center middle-header" width="10%">Jenis Sarana</th>--}}
{{--                    <th class="middle-header">Identitas Sarana</th>--}}
{{--                    <th class="text-center middle-header" width="12%">Berat Muat (Ton)</th>--}}
{{--                    <th class="text-center middle-header" width="12%">Berat Kosong (Ton)</th>--}}
{{--                    <th class="text-center middle-header" width="12%">Kecepatan Maksimum (Km/jam)</th>--}}
{{--                    <th class="text-center middle-header" width="15%">Kegunaan</th>--}}
                    <th class="text-center middle-header" width="15%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-detail-certification" tabindex="-1" aria-labelledby="modal-detail-certification"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Spesifikasi Teknis
                        Sarana Gerbong</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="wagon_sub_type" class="form-label">Jenis Gerbong</label>
                                <input type="text" class="form-control" id="wagon_sub_type"
                                       name="wagon_sub_type"
                                       disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="loading_weight" class="form-label">Berat Muat (Ton)</label>
                                <input type="number" step="any" class="form-control" id="loading_weight" name="loading_weight"
                                       placeholder="Berat Muat" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="empty_weight" class="form-label">Berat Kosong (Ton)</label>
                                <input type="number" step="any" class="form-control" id="empty_weight" name="empty_weight"
                                       placeholder="Berat Kosong" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="maximum_speed" class="form-label">Kecepatan Maksimum (Km/Jam)</label>
                                <input type="number" step="any" class="form-control" id="maximum_speed" name="maximum_speed"
                                       placeholder="Kecepatan Maksimum (VMax)" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="usability" class="form-label">Kegunaan</label>
                                <input type="text" step="any" class="form-control" id="usability" name="usability"
                                       placeholder="Kegunaan" disabled>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Dimensi</p>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="long" class="form-label">Panjang Total Gerbong (mm)</label>
                                <input type="number" step="any" class="form-control" id="long" name="long"
                                       placeholder="Panjang Total Gerbong" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="width" class="form-label">Lebar Gerbong (mm)</label>
                                <input type="number" step="any" class="form-control" id="width" name="width"
                                       placeholder="Lebar Gerbong" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="height_from_rail" class="form-label">Tinggi Lantai Dari Rel (mm)</label>
                                <input type="number" step="any" class="form-control" id="height_from_rail" name="height_from_rail"
                                       placeholder="Tinggi Lantai Dari Rel" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="axle_load" class="form-label">Beban Gandar (Ton)</label>
                                <input type="number" step="any" class="form-control" id="axle_load" name="axle_load"
                                       placeholder="Beban Gandar" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="bogie_distance" class="form-label">Jarak Antar Pusat Bogie (mm)</label>
                                <input type="number" step="any" class="form-control" id="bogie_distance" name="bogie_distance"
                                       placeholder="Jarak Antar Pusat Bogie" disabled>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <style>
        .middle-header {
            vertical-align: middle;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('technical-specification.wagon') }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                detailHandler(id);
            });
        }

        async function detailHandler(id) {
            try {
                let url = path + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let wagonType = data['wagon_sub_type']['code'] + ' ('+data['wagon_sub_type']['wagon_type']['code']+')';
                let emptyWeight = data['empty_weight'];
                let loadingWeight = data['loading_weight'];
                let maximumSpeed = data['maximum_speed'];
                let long = data['long'];
                let width = data['width'];
                let heightFromRail = data['height_from_rail'];
                let axleLoad = data['axle_load'];
                let bogieDistance = data['bogie_distance'];
                let usability = data['usability'];
                $('#wagon_sub_type').val(wagonType);
                $('#empty_weight').val(emptyWeight);
                $('#loading_weight').val(loadingWeight);
                $('#maximum_speed').val(maximumSpeed);
                $('#long').val(long);
                $('#width').val(width);
                $('#height_from_rail').val(heightFromRail);
                $('#axle_load').val(axleLoad);
                $('#bogie_distance').val(bogieDistance);
                $('#usability').val(usability);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
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

        function generateTable() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'table';
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center',
                },
                    {
                        data: 'wagon_sub_type',
                        name: 'wagon_sub_type',
                        render: function (data) {
                            return data['name'] + ' (' + data['wagon_type']['code'] + ')';
                        }
                    },
                    // {
                    //     data: 'facility_wagon.facility_number',
                    //     name: 'facility_wagon.facility_number',
                    // },
                    // {
                    //     data: 'empty_weight',
                    //     name: 'empty_weight',
                    //     className: 'text-center',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'loading_weight',
                    //     name: 'loading_weight',
                    //     className: 'text-center',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'maximum_speed',
                    //     name: 'maximum_speed',
                    //     className: 'text-center',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'usability',
                    //     name: 'usability',
                    //     className: 'text-center',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data['id'] + '">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            let url = path + '/' + data['id'] + '/dokumen';
                            return '<a href="' + url + '" class="btn-document btn-table-action">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            let url = path + '/' + data['id'] + '/gambar';
                            return '<a href="' + url + '" class="btn-image btn-table-action">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="' + urlEdit + '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false,
                        className: 'text-center',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
            });
        }

        $(document).ready(function () {
            generateTable();
        });
    </script>
@endsection
