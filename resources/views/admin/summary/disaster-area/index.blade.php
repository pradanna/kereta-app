@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">REKAPITULASI DAERAH RAWAN BENCANA</h1>
            <p class="mb-0">Rekapitulasi Data Jalur Perlintasan Langsun (JPL)</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekapitulasi Daerah Rawan Bencana</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Rekapitulasi Daerah Rawan Bencana</p>
        </div>
        <div class="isi">
            <p style="font-size: 14px; color: #777777; font-weight: bold;">Rekapitulasi Per Satuan Pelayanan</p>
            <table id="table-summary-service-unit" class="display table table-striped w-100 mb-3">
                <thead>
                <tr>
                    <th class="middle-header">Wilayah</th>
                    <th class="text-center middle-header" width="8%">Titik</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th class="middle-header">Jumlah</th>
                    <th class="text-center middle-header" width="8%">0</th>
                </tr>
                </tfoot>
            </table>
            <p class="mt-3" style="font-size: 14px; color: #777777; font-weight: bold;">Rekapitulasi Berdasarkan Jenis Rawan Jalan Rel</p>
            <table id="table-summary-disaster-type-road" class="display table table-striped w-100 mb-3">
                <thead>
                <tr>
                    <th class="middle-header">Wilayah</th>
                    @foreach($service_units as $service_unit)
                        <th class="text-center middle-header" width="8%">{{ $service_unit->name }}</th>
                    @endforeach
                    <th class="text-center middle-header" width="8%">Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th class="middle-header">Jumlah</th>
                    @foreach($service_units as $service_unit)
                        <th class="text-center middle-header" width="8%">0</th>
                    @endforeach
                    <th class="text-center middle-header" width="8%">0</th>
                </tr>
                </tfoot>
            </table>
            <p class="mt-3" style="font-size: 14px; color: #777777; font-weight: bold;">Rekapitulasi Berdasarkan Jenis Rawan Jembatan</p>
            <table id="table-summary-disaster-type-bridge" class="display table table-striped w-100 mb-3">
                <thead>
                <tr>
                    <th class="middle-header">Wilayah</th>
                    @foreach($service_units as $service_unit)
                        <th class="text-center middle-header" width="8%">{{ $service_unit->name }}</th>
                    @endforeach
                    <th class="text-center middle-header" width="8%">Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th class="middle-header">Jumlah</th>
                    @foreach($service_units as $service_unit)
                        <th class="text-center middle-header" width="8%">0</th>
                    @endforeach
                    <th class="text-center middle-header" width="8%">0</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let path = '{{ route('summary-disaster-area') }}';
        let serviceUnits = @json($service_units->pluck('id'));

        function generateSummaryByServiceUnit() {
            $('#table-summary-service-unit').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'service-unit';
                    }
                },
                columns: [
                    {data: 'name', name: 'name',},
                    {data: 'disaster_areas', name: 'disaster_areas', className: 'text-center'},
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
                    for (let i = 1; i < 2; i++) {
                        total = api
                            .column(i)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                        api.column(i).footer().innerHTML = total;
                    }

                }
            });
        }

        function generateSummaryByDisasterTypeRoad() {
            let columns = [{data: 'disaster_type', name: 'disaster_type'}];
            $.each(serviceUnits, function (k, v) {
                columns.push({data: v, name: v, className: 'text-center'})
            });
            columns.push({data: 'total', name: 'total', className: 'text-center'});
            $('#table-summary-disaster-type-road').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'disaster-type';
                        d.location_type = 'road';
                    }
                },
                columns: columns,
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
                    for (let i = 1; i < columns.length; i++) {
                        total = api
                            .column(i)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                        api.column(i).footer().innerHTML = total;
                    }

                }
            });
        }

        function generateSummaryByDisasterTypeBridge() {
            let columns = [{data: 'disaster_type', name: 'disaster_type'}];
            $.each(serviceUnits, function (k, v) {
                columns.push({data: v, name: v, className: 'text-center'})
            });
            columns.push({data: 'total', name: 'total', className: 'text-center'});
            $('#table-summary-disaster-type-bridge').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'disaster-type';
                        d.location_type = 'bridge';
                    }
                },
                columns: columns,
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
                    for (let i = 1; i < columns.length; i++) {
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
            generateSummaryByServiceUnit();
            generateSummaryByDisasterTypeRoad();
            generateSummaryByDisasterTypeBridge();
        });
    </script>
@endsection
