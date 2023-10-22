@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Perlintasan</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Perlintasan</p>
            <a class="btn-utama sml rnd " href="{{ route('track.create') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
{{--            <div class="d-flex align-items-center">--}}
{{--                <div class="flex-grow-1">--}}
{{--                    <p class="mb-0">Export Data</p>--}}
{{--                </div>--}}
{{--                <a class="btn-excel me-2" href="#">--}}
{{--                    Excel--}}
{{--                </a>--}}
{{--                <a class="btn-pdf me-2" href="#">--}}
{{--                    PDF--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <hr>--}}
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="15%">Wilayah</th>
                    <th width="12%">Kode</th>
                    <th>Nama</th>
                    <th width="10%" class="text-center">Aksi</th>
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
        let path = '{{ route('track') }}';
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
                    orderable: false
                },
                    {
                        data: 'area.name',
                        name: 'area.name'
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
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
                columnDefs: [{
                    targets: [0, 1, 2, 4],
                    className: 'text-center'
                }],
                paging: true,
            })
        })
    </script>
@endsection
