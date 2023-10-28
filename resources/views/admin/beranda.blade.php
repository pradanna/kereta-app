@extends('admin.base')

@section('title')
    Beranda
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>
    <script src="{{ asset('js/map-control.js?v=2') }}"></script>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <style>
        .select2-selection__rendered {
            line-height: 36px !important;
        }

        .select2-container .select2-selection--single {
            height: 36px !important;
            border: 1px solid #ddd;
        }

        .select2-selection__arrow {
            height: 36px !important;
        }

        #map {
            height: 500px;
            width: 100%
        }

        #main-map {
            height: 500px;
            width: 100%
        }

        #single-map-container {
            height: 450px;
            width: 50%
        }

        .marker-position {
            top: -25px;
            left: 0;
            position: relative;
            color: aqua;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="panel">
        <div class="title">
            <p>Jumlah Sarana</p>
        </div>
        <div class="isi">
            <p style="font-size: 14px; color: #777777; font-weight: bold;">Rekapitulasi Jumlah Sarana</p>
            <table id="table-data-facility-count" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="middle-header">Wilayah</th>
                    @foreach($facility_types as $facility_type)
                        <th class="text-center middle-header" width="8%">{{ $facility_type->name }}</th>
                    @endforeach
                    <th class="text-center middle-header" width="8%">Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Jumlah</th>
                    @foreach($facility_types as $facility_type)
                        <th class="text-center middle-header" width="8%">0</th>
                    @endforeach
                    <th class="text-center middle-header" width="8%">0</th>
                </tr>
                </tfoot>
            </table>
            <p class="mt-5" style="font-size: 14px; color: #777777; font-weight: bold;">Rekapitulasi Sertifikasi Kelaikan Sarana</p>
            <table id="table-data-facility-expiration" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="middle-header" rowspan="2">Wilayah</th>
                    @foreach($facility_types as $facility_type)
                        <th class="text-center middle-header" colspan="2">{{ $facility_type->name }}</th>
                    @endforeach
                    <th class="text-center middle-header" rowspan="2" width="8%">Total</th>
                </tr>
                <tr>
                    @foreach($facility_types as $facility_type)
                        <th class="text-center middle-header" width="5%">Berlaku</th>
                        <th class="text-center middle-header" width="5%">Kadaluarsa</th>
                    @endforeach
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Jumlah</th>
                    @foreach($facility_types as $facility_type)
                        <th class="text-center middle-header" width="5%">0</th>
                        <th class="text-center middle-header" width="5%">0</th>
                    @endforeach
                    <th class="text-center middle-header" width="8%">0</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>



    <!-- Modal -->
@endsection

@section('js')
    <script>
        let path = '{{ route('dashboard') }}';

        function generateFacilityCount() {
            $('#table-data-facility-count').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'total';
                    }
                },
                columns: [
                    {data: 'area', name: 'area',},
                    {data: 'locomotive', name: 'locomotive', className: 'text-center'},
                    {data: 'train', name: 'train', className: 'text-center'},
                    {data: 'diesel_train', name: 'diesel_train', className: 'text-center'},
                    {data: 'electric_train', name: 'electric_train', className: 'text-center'},
                    {data: 'wagon', name: 'wagon', className: 'text-center'},
                    {data: 'special_equipment', name: 'special_equipment', className: 'text-center'},
                    {data: 'total', name: 'total', className: 'text-center fw-bold'},
                ],
                columnDefs: [
                    {
                        target: '_all',
                        orderable: false
                    }
                ],
                dom: 't',
                footerCallback: function (row, data, start, end, display) {
                    let api = this.api();

                    let intVal = function (i) {
                        return typeof i === 'string'
                            ? i.replace(/[\$,]/g, '') * 1
                            : typeof i === 'number'
                                ? i
                                : 0;
                    };
                    for (let i = 1; i < 8; i++) {
                        total = api
                            .column(i)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                        api.column(i).footer().innerHTML = total;
                    }

                }
            });
        }

        function generateFacilityExpiration() {
            $('#table-data-facility-expiration').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'expiration';
                    }
                },
                columns: [
                    {data: 'area', name: 'area',},
                    {data: 'locomotive', name: 'locomotive', className: 'text-center'},
                    {data: 'locomotive_expired', name: 'locomotive_expired', className: 'text-center'},
                    {data: 'train', name: 'train', className: 'text-center'},
                    {data: 'train_expired', name: 'train_expired', className: 'text-center'},
                    {data: 'diesel_train', name: 'diesel_train', className: 'text-center'},
                    {data: 'diesel_train_expired', name: 'diesel_train_expired', className: 'text-center'},
                    {data: 'electric_train', name: 'electric_train', className: 'text-center'},
                    {data: 'electric_train_expired', name: 'electric_train_expired', className: 'text-center'},
                    {data: 'wagon', name: 'wagon', className: 'text-center'},
                    {data: 'wagon_expired', name: 'wagon_expired', className: 'text-center'},
                    {data: 'special_equipment', name: 'special_equipment', className: 'text-center'},
                    {data: 'special_equipment_expired', name: 'special_equipment_expired', className: 'text-center'},
                    {data: 'total', name: 'total', className: 'text-center fw-bold'},
                ],
                columnDefs: [
                    {
                        target: '_all',
                        orderable: false
                    }
                ],
                dom: 't',
                footerCallback: function (row, data, start, end, display) {
                    let api = this.api();

                    let intVal = function (i) {
                        return typeof i === 'string'
                            ? i.replace(/[\$,]/g, '') * 1
                            : typeof i === 'number'
                                ? i
                                : 0;
                    };
                    for (let i = 1; i < 14; i++) {
                        total = api
                            .column(i)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                        api.column(i).footer().innerHTML = total;
                    }

                }
            });
        }
        $(document).ready(function () {

            generateFacilityCount();
            generateFacilityExpiration();
        });
    </script>
@endsection
