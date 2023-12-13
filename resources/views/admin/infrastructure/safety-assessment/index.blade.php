@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SAFETY ASSESSMENT {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Safety Assessment {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('infrastructure') }}">Prasarana</a></li>
                <li class="breadcrumb-item active" aria-current="page">Safety Assessment {{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="row flex-grow-1 gx-2">
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="area" class="form-label d-none">Daerah Operasi</label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                <option value="">Semua Daerah Operasi</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none"></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Cari KM/HM atau No. Surat Rekomendasi">
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#" style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel w-100 shadow-sm">
        <div class="title">
            <p>Data Sertifikasi Sarana Lokomotif</p>
            <div class="d-flex align-item-center">
                <a class="btn-utama sml rnd me-2" href="#">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
                <a class="btn-success sml rnd" href="#" id="btn-export"
                   target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="text-center middle-header" width="10%">Wilayah</th>
                    <th class="text-center middle-header" width="10%">Lintas</th>
                    <th class="text-center middle-header" width="10%">Petak</th>
                    <th class="text-center middle-header" width="10%">Kota</th>
                    <th class="text-center middle-header" width="10%">Kecamatan</th>
                    <th class="text-center middle-header">No. Rekomendasi</th>
                    <th class="text-center middle-header" width="15%">Aksi</th>
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
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';

        function generateTableData() {
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
                        // d.service_unit = serviceUnitID;
                        d.area = $('#area-option').val();
                        d.name = $('#name').val();
                        // d.storehouse = $('#storehouse-option').val();
                        d.status = $('#status-option').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center'
                    // width: '30px'
                },
                    {
                        data: 'sub_track.track.area.name',
                        name: 'sub_track.track.area.name',
                        className: 'text-center'
                    },
                    {
                        data: 'sub_track.track.code',
                        name: 'sub_track.track.code',
                        className: 'text-center'
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center'
                    },
                    {
                        data: 'district.city.name',
                        name: 'district.city.name',
                        className: 'text-center'
                    },
                    {
                        data: 'district.name',
                        name: 'district.name',
                        className: 'text-center'
                    },
                    {
                        data: 'recommendation_number',
                        name: 'recommendation_number',
                        className: 'text-center',
                    },
                    {
                        data: null,
                        render: function (data) {
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data['id'] + '">Detail</a>';
                        },
                        orderable: false,
                        className: 'text-center',
                    }
                ],
                columnDefs: [
                    {
                        targets: '_all',
                        className: 'middle-header'
                    }
                ],
                paging: true,
                "fnDrawCallback": function (setting) {
                    // eventOpenDetail();
                },
                createdRow: function (row, data, index) {
                    // if (data['expired_in'] < expiration) {
                    //     $('td', row).css({
                    //         'background-color': '#fecba1'
                    //     });
                    // }
                },
                dom: 'ltrip'
            });
        }
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            generateTableData();
        });
    </script>
@endsection
