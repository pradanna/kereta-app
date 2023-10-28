@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">REKAPITULASI SARANA</h1>
            <p class="mb-0">Rekapitulasi Perhitungan Dan Kelaikan Sarana</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekapitulasi Sarana</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Rekapitulasi Sarana</p>

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
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let path = '{{ route('summary-facility') }}';
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
