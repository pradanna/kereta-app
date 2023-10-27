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
            <table id="table-data" class="display table table-striped w-100">
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
                    <th></th>
                    @foreach($facility_types as $facility_type)
                        <th class="text-center middle-header" width="8%">0</th>
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
        $(document).ready(function () {
            $('.table').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'table';
                    }
                },
                columns: [
                    { data: 'area', name: 'area',},
                    { data: 'locomotive', name: 'locomotive', className: 'text-center' },
                    { data: 'train', name: 'train', className: 'text-center' },
                    { data: 'diesel_train', name: 'diesel_train', className: 'text-center' },
                    { data: 'electric_train', name: 'electric_train', className: 'text-center' },
                    { data: 'wagon', name: 'wagon', className: 'text-center' },
                    { data: 'special_equipment', name: 'special_equipment', className: 'text-center' },
                    { data: 'total', name: 'total', className: 'text-center fw-bold' },
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
        });
    </script>
@endsection
