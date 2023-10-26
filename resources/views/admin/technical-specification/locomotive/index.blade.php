@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA LOKOMOTIF</h1>
            <p class="mb-0">Manajemen Data Spesifikasi Teknis Sarana Lokomotif</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Spesifikasi Teknis Sarana Lokomotif</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Spesifikasi Teknis Sarana Lokomotif</p>
            <a class="btn-utama sml rnd " href="{{ route('technical-specification.locomotive.add') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="text-center middle-header" width="10%">Jenis Sarana</th>
                    <th class="text-center middle-header">Identitas Sarana</th>
                    <th class="text-center middle-header" width="12%">Berat Kosong (Ton)</th>
                    <th class="text-center middle-header" width="12%">Horse Power (HP)</th>
                    <th class="text-center middle-header" width="12%">Kecepatan Maksimum (Km/jam)</th>
                    <th class="text-center middle-header" width="12%">Konsumsi BBM (Lt/Jam)</th>
                    {{--                    <th class="text-center" colspan="5">Dimensi</th>--}}
                    <th class="text-center middle-header" width="15%">Aksi</th>
                </tr>
                {{--                <tr>--}}
                {{--                    <th class="text-center middle-header">Panjang (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Lebar (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Tinggi (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Tinggi Coupler (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Diameter Roda (mm)</th>--}}
                {{--                </tr>--}}
                </thead>
                <tbody>
                </tbody>
            </table>
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
    <script>
        let table;
        let path = '{{ route('technical-specification.locomotive') }}';

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
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'facility_locomotive.locomotive_type.name',
                        name: 'facility_locomotive.locomotive_type.name',
                        className: 'text-center'
                    },
                    {
                        data: 'facility_locomotive.facility_number',
                        name: 'facility_locomotive.facility_number',
                        className: 'text-center'
                    },
                    {
                        data: 'empty_weight',
                        name: 'empty_weight',
                        className: 'text-center',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'house_power',
                        name: 'house_power',
                        className: 'text-center',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'maximum_speed',
                        name: 'maximum_speed',
                        className: 'text-center',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'fuel_consumption',
                        name: 'fuel_consumption',
                        className: 'text-center',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
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
                    //     data: 'wheel_diameter',
                    //     name: 'wheel_diameter',
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
                    // eventOpenDetail();
                    // deleteEvent();
                },
            });
        }

        $(document).ready(function () {
            generateTable();
        });
    </script>
@endsection
