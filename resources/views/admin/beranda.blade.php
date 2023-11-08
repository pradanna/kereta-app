@extends('admin.base')

@section('title')
    Beranda
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="{{ asset('js/map-control.js?v=2') }}"></script>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
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
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">Semua</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Satpel 1</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                    type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Satpel 2</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="d-flex gap-3 mt-5">
                    {{-- ITEM --}}
                    <div class="dsh-item color1">
                        <p class="name">Lokomotif</p>
                        <p class="total">1.320</p>
                        <p class="keterangan">dari semua wilayah</p>
                    </div>

                    <div class="dsh-item color2">
                        <p class="name">Kereta</p>
                        <p class="total">1.320</p>
                        <p class="keterangan">dari semua wilayah</p>
                    </div>

                    <div class="dsh-item color3">
                        <p class="name">Barang Lain</p>
                        <p class="total">1.320</p>
                        <p class="keterangan">dari semua wilayah</p>
                    </div>

                    <div class="dsh-item color4">
                        <p class="name">Barang Lain</p>
                        <p class="total">1.320</p>
                        <p class="keterangan">dari semua wilayah</p>
                    </div>
                </div>

                <div class="table-container mt-5" style="min-height: 500px">
                    <table id="table-data" class="display table table-striped w-100">
                        <thead>
                            <tr>
                                <th class="text-center middle-header" width="5%">#</th>
                                {{--                                <th class="text-center">Tipe Sarana</th> --}}
                                <th class="text-center middle-header" width="10%">Wilayah</th>
                                <th class="text-center middle-header" width="10%">Kepemilikan</th>
                                <th class="text-center middle-header" width="12%">No. Sarana</th>
                                {{--                                <th class="text-center">Tipe Depo</th> --}}
                                <th class="text-center middle-header" width="8%">Depo Induk</th>
                                {{--                                <th class="text-center">Mulai Dinas</th> --}}
                                <th class="text-center middle-header">No. BA Pengujian</th>
                                <th class="text-center middle-header" width="10%">Masa Berlaku Sarana</th>
                                <th class="text-center middle-header" width="5%">Akan Habis (Hari)</th>
                                {{--                                <th class="text-center">Status</th> --}}
                                <th class="text-center middle-header" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
        </div>
    </div>



    <!-- Modal -->
@endsection

@section('js')
    <script>
        let path = '{{ route('dashboard') }}';
        $(document).ready(function() {


        });
    </script>
@endsection
