@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title-container">
            <h1 class="h1">JALUR PERLINTASAN LANGSUNG</h1>
            <p class="mb-0">Data Jalur Perlintasan Langsung</p>
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
            <table id="table-data" class="display table table-striped">
                <thead>
                <tr>
                    <th class="text-center middle-header">#</th>
                    <th class="text-center middle-header">Wilayah</th>
                    <th class="text-center middle-header">Perlintasan</th>
                    <th class="text-center middle-header">Antara</th>
                    <th class="text-center middle-header">JPL</th>
                    <th class="text-center middle-header">KM/HM</th>
                    <th class="text-center middle-header">Lebar Jalan</th>
                    <th class="text-center middle-header">Konstruksi Jalan</th>
                    <th class="text-center middle-header">Nama Jalan</th>
                    <th class="text-center middle-header">Kodya / Kabupaten</th>
                    <th class="text-center middle-header">Koordinat</th>
                    <th class="text-center middle-header">Usulan Penataan</th>
                    <th class="text-center middle-header">Riwayat Kecelakaan</th>
                    <th class="text-center middle-header">Keterangan</th>
                    <th class="text-center middle-header">Aksi</th>
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
                    width: '30'
                },
                    {
                        data: 'sub_track.track.area.name',
                        name: 'sub_track.track.area.name',
                        width: '100px',
                    },
                    {
                        data: 'sub_track.track.code',
                        name: 'sub_track.track.code',
                        width: '100px',
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        width: '100px',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        width: '100px',
                    },
                    {
                        data: 'stakes',
                        name: 'stakes',
                        width: '100px',
                    },
                    {
                        data: 'width',
                        name: 'width',
                        width: '100px',
                    },
                    {
                        data: 'road_construction',
                        name: 'road_construction',
                        width: '100px',
                    },
                    {
                        data: 'road_name',
                        name: 'road_name',
                        width: '100px',
                    },
                    {
                        data: 'city.name',
                        name: 'city.name',
                        width: '100px',
                    },
                    {
                        data: null,
                        width: '100px',
                        render: function (data) {
                            return '-';
                        }
                    },
                    {
                        data: 'arrangement_proposal',
                        name: 'arrangement_proposal',
                        width: '100px',
                    },
                    {
                        data: 'accident_history',
                        name: 'accident_history',
                        width: '100px',
                    },
                    {
                        data: 'description',
                        name: 'description',
                        width: '100px',
                    },
                    {
                        data: null,
                        render: function (data) {
                            return '<a href="#" class="btn-edit me-1" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete" data-id="' + data['id'] +
                                '">Delete</a>'
                        },
                        orderable: false
                    }
                ],
                columnDefs: [],
                paging: true,
            })
        })
    </script>
@endsection
