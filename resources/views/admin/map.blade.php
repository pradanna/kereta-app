@if($data == 'content')
    <div class="panel">
        <div id="map"></div>
    </div>
@elseif($data == 'script')

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
@endif
