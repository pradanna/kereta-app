@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
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
                    <th class="text-center middle-header">Resmi Di Jaga KAI OP</th>
                    <th class="text-center middle-header">Resmi Di Jaga JJ</th>
                    <th class="text-center middle-header">Resmi Di Jaga Pemda / Instansi Lain</th>
                    <th class="text-center middle-header">Resmi Di Jaga Swadaya</th>
                    <th class="text-center middle-header">Resmi Tidak Di Jaga</th>
                    <th class="text-center middle-header">Liar</th>
                    <th class="text-center middle-header">Di Tutup</th>
                    <th class="text-center middle-header">Tidak Ditemukan</th>
                    <th class="text-center middle-header">Underpass</th>
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
                        data: 'is_verified_by_operator',
                        name: 'is_verified_by_operator',
                        width: '100px',
                    },{
                        data: 'is_verified_by_unit_track_and_bridge',
                        name: 'is_verified_by_unit_track_and_bridge',
                        width: '100px',
                    },{
                        data: 'is_verified_by_institution',
                        name: 'is_verified_by_institution',
                        width: '100px',
                    },{
                        data: 'is_verified_by_independent',
                        name: 'is_verified_by_independent',
                        width: '100px',
                    },{
                        data: 'is_verified_by_unguarded',
                        name: 'is_verified_by_unguarded',
                        width: '100px',
                    },{
                        data: 'is_illegal',
                        name: 'is_illegal',
                        width: '100px',
                    },{
                        data: 'is_closed',
                        name: 'is_closed',
                        width: '100px',
                    },{
                        data: 'is_not_found',
                        name: 'is_not_found',
                        width: '100px',
                    },{
                        data: 'is_underpass',
                        name: 'is_underpass',
                        width: '100px',
                    },{
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
