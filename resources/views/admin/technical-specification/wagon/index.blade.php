@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
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
            <table id="table-data" class="display table table-striped">
                <thead>
                <tr>
                    <th class="text-center middle-header" rowspan="2">#</th>
                    <th class="text-center middle-header" rowspan="2">Identitas Sarana</th>
                    <th class="text-center middle-header" rowspan="2">Jenis Sarana</th>
                    <th class="text-center middle-header" rowspan="2">Berat Muat (Ton)</th>
                    <th class="text-center middle-header" rowspan="2">Berat Kosong (Ton)</th>
                    <th class="text-center middle-header" rowspan="2">Kecepatan Maksimum (Km/jam)</th>
                    <th class="text-center middle-header" colspan="5">Dimensi</th>
                    <th class="text-center middle-header" rowspan="2">Kegunaan</th>
                    <th class="text-center middle-header" rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th class="text-center middle-header">Panjang Total Gerbong (mm)</th>
                    <th class="text-center middle-header">Lebar Gerbong (mm)</th>
                    <th class="text-center middle-header">Beban Gandar (Ton)</th>
                    <th class="text-center middle-header">Tinggi Lantai Dari REL (mm)</th>
                    <th class="text-center middle-header">Jarak Antar Pusat Bogie (mm)</th>
                </tr>
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
        let path = '{{ route('technical-specification.wagon') }}';

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
                        data: 'facility_wagon.facility_number',
                        name: 'facility_wagon.facility_number',
                        width: '120px',
                    },
                    {
                        data: 'facility_wagon.wagon_sub_type',
                        name: 'facility_wagon.wagon_sub_type',
                        width: '120px',
                        render: function (data) {
                            return data['name'] + ' (' + data['wagon_type']['code'] + ')';
                        }
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
                        data: 'loading_weight',
                        name: 'loading_weight',
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
                        data: 'long',
                        name: 'long',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'width',
                        name: 'width',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'height_from_rail',
                        name: 'height_from_rail',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'axle_load',
                        name: 'axle_load',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'bogie_distance',
                        name: 'bogie_distance',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'usability',
                        name: 'usability',
                        width: '150px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            return '<a href="#" class="btn-edit me-1" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete" data-id="' + data['id'] + '">Delete</a>'
                        },
                        orderable: false,
                        width: '120px',
                    }
                ],
                columnDefs: [{
                    targets: '_all',
                    className: 'text-center'
                }]
            });
        }

        $(document).ready(function () {
            generateTable();
        });
    </script>
@endsection
