@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">JALUR PERLINTASAN LANGSUNG</h1>
            <p class="mb-0">Manajemen Data Jalur Perlintasan Langsung</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Jalur Perlintasan Langsung (JPL)</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Jalur Perlintasan Langsung (JPL)</p>
            <a class="btn-utama sml rnd " href="{{ route('direct-passage.add') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="text-center middle-header" width="10%">Wilayah</th>
                    <th class="text-center middle-header" width="10%">Perlintasan</th>
                    <th class="text-center middle-header" width="10%">Antara</th>
                    <th class="text-center middle-header" width="7%">JPL</th>
                    <th class="text-center middle-header" width="8%">KM/HM</th>
                    <th class="text-center middle-header" width="10%">Lebar Jalan</th>
                    <th class="middle-header">Nama Jalan</th>
                    <th class="text-center middle-header" width="15%">Aksi</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script>
        let table;
        let path = '{{ route('direct-passage') }}';
        $(document).ready(function () {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: path,
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center',
                },
                    {
                        data: 'sub_track.track.area.name',
                        name: 'sub_track.track.area.name',
                        className: 'text-center',
                    },
                    {
                        data: 'sub_track.track.code',
                        name: 'sub_track.track.code',
                        className: 'text-center',
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center',
                    },
                    {
                        data: 'stakes',
                        name: 'stakes',
                        className: 'text-center',
                    },
                    {
                        data: 'width',
                        name: 'width',
                        className: 'text-center',
                    },
                    {
                        data: 'road_name',
                        name: 'road_name',

                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data['id'] + '">Detail</a>' +
                                '<a href="' + urlEdit + '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
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
            })
        })
    </script>
@endsection
