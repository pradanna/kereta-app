@extends('admin.base')

@section('title')
    Beranda
@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
        <script src="{{ asset('js/map-control.js?v=2') }}"></script>

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
            <p>Portfolio</p>
        </div>

        <div class="isi">
            <div class="row" id="cardType">
            </div>

        </div>
    </div>

    <div class="panel">
        <div class="title">
            <p>Titik yang baru dimasukan</p>
            <a class="btn-utama-soft sml rnd " id="addData">Titik Baru <i class="material-symbols-outlined menu-icon ms-2"
                    data-toggle="modal" data-bs-backdrop="static">add_circle</i></a>
        </div>

        @include('admin.item-table')


    </div>

    <!-- Modal -->
    @include('admin.item-modal')
@endsection

@section('morejs')
    {{--    <script src="{{ asset('js/number_formater.js') }}"></script> --}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script src="{{ asset('js/currency.js') }}"></script>

    {{-- @include('admin.map', ['data' => 'script']) --}}

    <script src="{{ asset('js/item.js?v=4') }}"></script>
    <script>
        $(document).ready(function() {
            onTabChange();
            getCard();
            datatableItem();
            getSelect('type', '/data/type');
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
        });



        function getCard() {
            $.get('/data/item/card', function(data, status, response) {
                let card = $('#cardType');
                card.empty;
                if (response.status === 200) {
                    $.each(data, function(k, v) {
                        let img = v.icon;
                        card.append('<div class="col-4 my-2 ">\n' +
                            '                        <div class="panel-peformace p-2">\n' +
                            '                            <img src="' + img + '"/>\n' +
                            '                            <div class="content">\n' +
                            '                                <p class="nama">' + v.name + '</p>\n' +
                            '                                <p class="nilai">' + v.count +
                            ' Titik</p>\n' +
                            '                            </div>\n' +
                            '                        </div>\n' +
                            '                    </div>')
                    })
                }
            })
        }

        // $('#modaltambahtitik').modal({backdrop: 'static', keyboard: false})
    </script>
@endsection
