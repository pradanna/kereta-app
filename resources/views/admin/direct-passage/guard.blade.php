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
                <li class="breadcrumb-item"><a href="{{ route('direct-passage') }}">Jalur Perlintasan Langsung (JPL)</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">PJL {{ $data->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Penjaga Jalur Lintasan {{ $data->name }}</p>
            <div class="d-flex align-item-center">
                {{--                <a class="btn-success sml rnd" href="#" id="btn-export">Export--}}
                {{--                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>--}}
                {{--                </a>--}}
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="middle-header">Nama</th>
                    <th class="text-center middle-header" width="20%">Kartu Kecakapan</th>
                    <th class="text-center middle-header" width="20%">No. Diklat / Bintek JPL</th>
                    <th class="text-center middle-header" width="12%">Tanggal Kadaluarsa</th>
                    <th class="text-center middle-header" width="10%">Kadaluarsa</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';


        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });

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
                        data: 'human_resource.name',
                        name: 'human_resource.name'
                    },
                    {
                        data: 'human_resource.skill_card_id',
                        name: 'human_resource.skill_card_id',
                        render: function (data) {
                            if (data === '') {
                                return '-';
                            }
                            return data;
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'human_resource.training_card_id',
                        name: 'human_resource.training_card_id',
                        render: function (data) {
                            if (data === '') {
                                return '-';
                            }
                            return data;
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'human_resource.card_expired',
                        name: 'human_resource.card_expired',
                        render: function (data) {
                            if (data === null) {
                                return '-';
                            }
                            const v = new Date(data);
                            return v.toLocaleDateString('id-ID', {
                                month: '2-digit',
                                year: 'numeric',
                                day: '2-digit'
                            }).split('/').join('-')
                        },
                        className: 'text-center',
                    },
                    {
                        data: null,
                        name: null,
                        render: function (data) {
                            if (data['human_resource']['card_expired'] === null) {
                                return '-';
                            }
                            let value = 'Berlaku';
                            if (data['expired_in'] <= 0) {
                                value = 'Kadaluarsa';
                            }
                            return value;
                        },
                        className: 'text-center',
                    },
                ]
            });
        })
    </script>
@endsection
