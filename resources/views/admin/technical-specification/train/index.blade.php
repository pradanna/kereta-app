@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
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
            <table id="table-data" class="display table table-striped">
                <thead>
                <tr>
                    <th class="text-center middle-header" rowspan="2">#</th>
                    <th class="text-center middle-header" rowspan="2">Identitas Sarana</th>
                    <th class="text-center middle-header" rowspan="2">Jenis Sarana</th>
                    <th class="text-center middle-header" rowspan="2">Berat Kosong (Ton)</th>
                    <th class="text-center middle-header" rowspan="2">Kecepatan Maksimum (Km/jam)</th>
                    <th class="text-center middle-header" rowspan="2">Jumlah Tempat Duduk</th>
                    <th class="text-center middle-header" rowspan="2">Jenis AC</th>
                    <th class="text-center" colspan="6">Dimensi</th>
                    <th class="text-center middle-header" rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th class="text-center middle-header">Panjang (mm)</th>
                    <th class="text-center middle-header">Lebar (mm)</th>
                    <th class="text-center middle-header">Tinggi (mm)</th>
                    <th class="text-center middle-header">Tinggi Coupler (mm)</th>
                    <th class="text-center middle-header">Beban Gandar (Ton)</th>
                    <th class="text-center middle-header">Lebar Spoor (mm)</th>
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
        let path = '{{ route('technical-specification.train') }}';

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
                    'data': function(d) {
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
                        data: 'facility_train.facility_number',
                        name: 'facility_train.facility_number',
                        width: '120px',
                    },
                    {
                        data: 'facility_train.train_type.name',
                        name: 'facility_train.train_type.name',
                        width: '120px'
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
                        data: 'height',
                        name: 'height',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'coupler_height',
                        name: 'coupler_height',
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
                        data: 'spoor_width',
                        name: 'spoor_width',
                        width: '100px',
                        render: function (data) {
                            return data.toLocaleString('id-ID');
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
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

        $(document).ready(function() {
            generateTable();
        });
    </script>
@endsection
