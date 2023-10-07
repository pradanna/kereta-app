@extends('admin.base')
@section('title')
    Titik Iklan
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

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

        /*.leaflet-container {*/
        /*    height: 400px;*/
        /*    width: 600px;*/
        /*    max-width: 100%;*/
        /*    max-height: 100%;*/
        /*}*/
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
    <script src="{{ asset('js/map-control.js?v=2') }}"></script>
@endsection
@section('content')
    <div>

        <div class="d-flex justify-content-between">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab active" id="pills-tabel-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-tabel" type="button" role="tab" aria-controls="pills-tabel"
                        aria-selected="true">Tabel
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link genostab" id="pills-peta-tab" data-bs-toggle="pill" data-bs-target="#pills-peta"
                        type="button" role="tab" aria-controls="pills-peta" aria-selected="false">Maps
                    </button>
                </li>

            </ul>
            <div>
                <a class="btn-utama sml rnd flex" href="#" role="button" id="dropSearch" data-bs-toggle="dropdown"
                    aria-expanded="false">Filter
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">filter_list</i></a>
                <ul id="dropSearchList" class="dropdown-menu custom" aria-labelledby="dropSearch">
                    <div class="filter-panel">
                        <div class="form-group">
                            <label for="f-provinsi" class="form-label">Provinsi</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-provinsi"
                                name="f-provinsi">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="f-kota" class="form-label">Kota</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-kota"
                                name="f-kota">
                                <option selected value="">Semua Kota</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="f-tipe" class="form-label">Tipe</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-tipe"
                                name="f-tipe">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="f-posisi" class="form-label">Posisi</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="f-posisi"
                                name="f-posisi">
                                <option selected value="">Semua Posisi</option>
                                <option value="Horizontal">Horizontal</option>
                                <option value="Vertical">Vertical</option>
                            </select>
                        </div>

                    </div>
                </ul>

            </div>
        </div>
        <div class="mb-2" id="pillSearch">
            {{-- <span id="pillProvince" class="badge bg-primary " style="border-radius: 200px; align-items: center"><span id="text" class="text">asdasd</span>  <a role="button"><i class="material-symbols-outlined" style="font-size: 12px">close</i></a></span> --}}

        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-tabel" role="tabpanel" aria-labelledby="pills-tabel-tab">
                <div class="panel">
                    <div class="title">
                        <p>Titik yang baru dimasukan</p>
                        <a class="btn-utama-soft sml rnd " id="addData">Titik Baru <i
                                class="material-symbols-outlined menu-icon ms-2">add_circle</i></a>
                    </div>
                    @include('admin.item-table')

                </div>

            </div>
            <div class="tab-pane fade" id="pills-peta" role="tabpanel" aria-labelledby="pills-peta-tab">
                {{-- @include('admin.map', ['data' => 'content']) --}}
                <div id="main-map" style="width: 100%; height: 500px; height: calc(100vh - 70px)"></div>
            </div>
        </div>

        <!-- Modal -->
        @include('admin.item-modal')

    </div>
@endsection

@section('morejs')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    {{--    <script src="{{ asset('js/number_formater.js') }}"></script> --}}
    <script src="{{ asset('js/currency.js') }}"></script>

    {{--    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" --}}
    {{--            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" --}}
    {{--            crossorigin=""></script> --}}

    {{-- @include('admin.map', ['data' => 'script']) --}}

    {{--    <script src="{{ asset('js/map-control.js') }}"></script> --}}
    <script src="{{ asset('js/item.js?v=4') }}"></script>

    <script>
        $(document).ready(function() {
            // generateGoogleMapData().then(r => {})
            onTabChange();
            $("#simple-modal-detail").on("shown.bs.modal", function() {

            });
            datatableItem();
            getSelect('f-provinsi', '/data/province', 'name', null, 'Semua Provinsi');
            getSelect('type', '/data/type')
            getSelect('f-tipe', '/data/type', 'name', null, 'Semua Type');
            getSelect('f-kota', '/data/city', 'name', null, 'Semua Kota');

            setImgDropify('image1');
            setImgDropify('image2');
            setImgDropify('image3');
            saveItem();
            currency('height');
            currency('width');
            $('#province').select2({
                dropdownParent: $("#modaltambahtitik")
            });
            $('#city').select2({
                dropdownParent: $("#modaltambahtitik")
            });

            $('#vendor').select2({
                dropdownParent: $("#modaltambahtitik")
            });
            // $('#f-provinsi').select2({
            //     dropdownParent: $("#dropSearch")
            // });
            // $('#f-tipe').select2();
        });
    </script>
@endsection
