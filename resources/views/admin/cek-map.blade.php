@extends('admin.base')

@section('title')
    Maps
@endsection


@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
          integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
          crossorigin=""/>
    <style>
        #map {
            height: 500px;
            width: 100%
        }
    </style>
@endsection
@section('content')
    <div class="panel">
        <div id="map"></div>
    </div>
@endsection

@section('morejs')
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin=""></script>
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script>
        var center = {
            lat: -7.57797433093528, lng: 110.80924297710521
        };
        var map = L.map('map').setView([center['lat'], center['lng']], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);
        var marker = L.marker([center['lat'], center['lng']]).addTo(map);

        async function getPlacesData() {
            try {
                let response = await $.get('/cek-map/data');
                L.geoJSON(response.payload, {
                    pointToLayer: function (geoJsonPoint, latlng) {
                        console.log(geoJsonPoint);
                        return L.marker(latlng);
                    }
                })
                    .bindPopup(function (layer) {
                        //return layer.feature.properties.map_popup_content;
                        return ('<div class="my-2"><strong>Place Name</strong> :<br>' + layer.feature.properties.name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + layer.feature.properties.address + '</div><div class="my-2"><strong>Address</strong>:<br>' + layer.feature.properties.address + '</div>');
                    }).addTo(map);
                console.log(response);
            } catch (e) {
                console.log(e)
            }
        }

        $(document).ready(function () {
            // fetch('/border.geojson').then(response => response.text()).then(text => text).then(function (payload) {
            //     let json = JSON.parse(payload);
            //     for (let i = 0; i < 10; i++) {
            //         console.log(json[i]);
            //     }
            // });
            getPlacesData();
        })
    </script>
@endsection
