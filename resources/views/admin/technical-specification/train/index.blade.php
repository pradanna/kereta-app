@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA KERETA</h1>
            <p class="mb-0">Manajemen Data Spesifikasi Teknis Sarana Kereta</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Spesifikasi Teknis Sarana Kereta</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Spesifikasi Teknis Sarana Kereta</p>
            <a class="btn-utama sml rnd " href="{{ route('technical-specification.train.add') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="text-center middle-header" width="15%">Jenis Sarana</th>
                    <th class="text-center middle-header">Identitas Sarana</th>
                    <th class="text-center middle-header" width="10%">Berat Kosong (Ton)</th>
                    <th class="text-center middle-header" width="10%">Kecepatan Maksimum (Km/jam)</th>
                    <th class="text-center middle-header" width="12%">Jumlah Tempat Duduk</th>
                    <th class="text-center middle-header" width="12%">Jenis AC</th>
                    {{--                    <th class="text-center" colspan="6">Dimensi</th>--}}
                    <th class="text-center middle-header" width="15%">Aksi</th>
                </tr>
                {{--                <tr>--}}
                {{--                    <th class="text-center middle-header">Panjang (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Lebar (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Tinggi (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Tinggi Coupler (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Beban Gandar (Ton)</th>--}}
                {{--                    <th class="text-center middle-header">Lebar Spoor (mm)</th>--}}
                {{--                </tr>--}}
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
                    ...
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
        let path = '{{ route('technical-specification.train') }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                modalDetail.show();
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
                    width: '30px'
                },
                    {
                        data: 'facility_train.train_type.name',
                        name: 'facility_train.train_type.name',
                        className: 'text-center'
                    },
                    {
                        data: 'facility_train.facility_number',
                        name: 'facility_train.facility_number',
                        className: 'text-center'
                    },

                    {
                        data: 'empty_weight',
                        name: 'empty_weight',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'maximum_speed',
                        name: 'maximum_speed',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'passenger_capacity',
                        name: 'passenger_capacity',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'air_conditioner',
                        name: 'air_conditioner',
                        width: '100px'
                    },
                    // {
                    //     data: 'long',
                    //     name: 'long',
                    //     width: '100px',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'width',
                    //     name: 'width',
                    //     width: '100px',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'height',
                    //     name: 'height',
                    //     width: '100px',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'coupler_height',
                    //     name: 'coupler_height',
                    //     width: '100px',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'axle_load',
                    //     name: 'axle_load',
                    //     width: '100px',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    // {
                    //     data: 'spoor_width',
                    //     name: 'spoor_width',
                    //     width: '100px',
                    //     render: function (data) {
                    //         return data.toLocaleString('id-ID');
                    //     }
                    // },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="#" class="btn-detail me-2 btn-table-action">Detail</a>' +
                                '<a href="' + urlEdit + '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false,
                        className: 'text-center'
                    }
                ],
                columnDefs: [
                    // {
                    //     targets: '_all',
                    //     className: 'text-center'
                    // }
                ],
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
