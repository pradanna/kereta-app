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
    <div class="panel p-3" style="min-height: 90vh">
        <div class="d-flex gap-3 justify-content-between ">
            {{-- ITEM --}}
            <div class="dsh-item color1">
                <p class="name">Lokomotif</p>
                <p class="total">{{ $facility_locomotives }}</p>
                <p class="keterangan">dari semua wilayah</p>
            </div>

            <div class="dsh-item color2">
                <p class="name">Kereta</p>
                <p class="total">{{ $facility_trains }}</p>
                <p class="keterangan">dari semua wilayah</p>
            </div>

            <div class="dsh-item color3">
                <p class="name">Gerbong</p>
                <p class="total">{{ $facility_wagons }}</p>
                <p class="keterangan">dari semua wilayah</p>
            </div>

            <div class="dsh-item color4">
                <p class="name">Peralatan Khusus</p>
                <p class="total">{{ $facility_special_equipments }}</p>
                <p class="keterangan">dari semua wilayah</p>
            </div>
        </div>
        <p class="mb-1 mt-3 fw-bold" style="color: #777777;">Peta Satuan Pelayanan</p>
        <div class="row gx-3">
            <div class="col-8">
                <div id="main-map" class="panel"
                     style="margin-bottom: 0; width: 100%; height: 500px; border-radius: 10px;">
                </div>
            </div>
            <div class="col-4">
                <div class="panel" style="margin-bottom: 10px;">
                    <div class="title">
                        <p class="fw-bold">Masa Berlaku Sarana Akan Habis</p>
                        <a class="btn-detail btn-table-action" href="{{ route('summary-facility') }}">Detail</a>
                    </div>
                    <div class="isi">
                        @foreach($facility_expirations as $facility_expiration)
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="fw-bold">{{ $facility_expiration['type'] }}</p>
                                <p class="fw-bold">{{ $facility_expiration['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="panel">
                    <div class="title">
                        <p class="fw-bold">Daerah Rawan Bencana</p>
                        <a class="btn-detail btn-table-action" href="{{ route('disaster-area') }}">Detail</a>
                    </div>
                    <div class="isi">
                        @foreach($service_units as $service_unit)
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <p class="fw-bold">{{ $service_unit->name }}</p>
                                <p class="fw-bold">{{ $service_unit->disaster_areas }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
{{--        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">--}}
{{--            <li class="nav-item" role="presentation">--}}
{{--                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"--}}
{{--                        type="button" role="tab" aria-controls="pills-home" aria-selected="true">Semua--}}
{{--                </button>--}}
{{--            </li>--}}
{{--            <li class="nav-item" role="presentation">--}}
{{--                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"--}}
{{--                        type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Satpel 1--}}
{{--                </button>--}}
{{--            </li>--}}
{{--            <li class="nav-item" role="presentation">--}}
{{--                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"--}}
{{--                        type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Satpel 2--}}
{{--                </button>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <div class="tab-content" id="pills-tabContent">--}}
{{--            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">--}}

{{--            </div>--}}
{{--            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>--}}
{{--            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>--}}
{{--        </div>--}}
    </div>



    <!-- Modal -->
@endsection

@section('css')
    <script src="{{ asset('js/map-control.js') }}"></script>
@endsection
@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script>
        let currentPath = '{{ route('dashboard') }}';
        let path = '{{ route('service-unit') }}';
        function getDataServiceUnitMap() {
            let url = path + '?type=map';
            return $.get(url)
        }

        function generateMapServiceUnit() {
            getDataServiceUnitMap().then((response) => {
                removeMultiMarker();
                let data = response.data;
                if (data.length > 0) {
                    createMultiMarkerServiceUnit(data)
                }
            }).catch((e) => {
                console.log(e)
            })
        }
        $(document).ready(function () {
            generateMapServiceUnit()
        });
    </script>
@endsection
