var map_container;
var map_container_single;
var center_indonesia = {
    lat: -0.4029326, lng: 110.5938779
};

// function generateMap(element) {
//     if (map_container === undefined) {
//         map_container = L.map(element).setView([center_indonesia['lat'], center_indonesia['lng']], 5);
//         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             maxZoom: 19,
//             attribution: '© OpenStreetMap'
//         }).addTo(map_container);
//     }
//     getPlacesData().then(r => {
//     });
// }
//
//
// function createMarker(geoJsonPayload) {
//     L.geoJSON(geoJsonPayload, {
//         pointToLayer: function (geoJsonPoint, latlng) {
//             let icon_url = geoJsonPoint['properties']['type'] !== null ? window.location.origin + geoJsonPoint['properties']['type']['icon'] : '';
//             var greenIcon = L.icon({
//                 iconUrl: icon_url,
//                 iconSize: [40, 40], // size of the icon
//             });
//             return L.marker(latlng, {icon: greenIcon});
//         }
//     }).bindPopup(function (layer) {
//         return ('<div class="my-2"><strong>Place Name</strong> :<br>' + layer.feature.properties.name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + layer.feature.properties.address + '</div><div class="my-2"><strong>Address</strong>:<br>' + layer.feature.properties.address + '</div>');
//     }).addTo(map_container);
// }
//
// async function getPlacesData() {
//     try {
//         let response = await $.get('/cek-map/data?province=' + s_provinsi + '&city=' + s_kota + '&type=' + s_tipe + '&position=' + s_posisi);
//         let geoJSONPayload = response['payload'];
//         createMarker(geoJSONPayload);
//         let tmp_bound = [];
//         let features_data = response['payload']['features'];
//         $.each(features_data, function (k, v) {
//             tmp_bound.push([
//                 v['properties']['latitude'],
//                 v['properties']['longitude'],
//             ]);
//         });
//         map_container.fitBounds(tmp_bound);
//     } catch (e) {
//         console.log(e);
//     }
// }
//
// function generateSingleMap(element, id) {
//     if (map_container_single === undefined) {
//         map_container_single = L.map(element).setView([center_indonesia['lat'], center_indonesia['lng']], 16);
//         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             maxZoom: 19,
//             attribution: '© OpenStreetMap'
//         }).addTo(map_container_single);
//     }
//     getDetailPlace(id).then(r => {
//     })
// }
//
// async function getDetailPlace(id) {
//     try {
//         let response = await $.get('/cek-map/data-detail/' + id);
//         removeSingleMarkerLayer();
//         createSingleMarker(response['payload'])
//     } catch (e) {
//         console.log(e);
//     }
// }
//
// function createSingleMarker(payload) {
//     let coordinate = [payload['latitude'], payload['longitude']];
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         maxZoom: 19,
//         attribution: '© OpenStreetMap'
//     }).addTo(map_container_single);
//     var layerGroup = L.layerGroup();
//     let icon_url = payload['type'] !== null ? window.location.origin + payload['type']['icon'] : '';
//     var greenIcon = L.icon({
//         iconUrl: icon_url,
//         iconSize: [40, 40], // size of the icon
//     });
//     let marker = L.marker(coordinate, {icon: greenIcon});
//     marker.bindPopup(
//         '<div class="my-2"><strong>Place Name</strong> :<br>' + payload.name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + payload.address + '</div><div class="my-2"><strong>Address</strong>:<br>' + payload.address + '</div>');
//     layerGroup.addLayer(marker)
//     map_container_single.addLayer(layerGroup);
//     map_container_single.panTo(new L.LatLng(payload['latitude'], payload['longitude']));
// }
//
// function removeSingleMarkerLayer() {
//     if(map_container_single !== undefined) {
//         map_container_single.eachLayer(function (layer) {
//             map_container_single.removeLayer(layer);
//         });
//     }
// }

function initMap() {
    const myLatLng = {lat: -7.5589494045543475, lng: 110.85658809673708};
    map_container = new google.maps.Map(document.getElementById("main-map"), {
        zoom: 14,
        center: myLatLng,
    });
}

async function generateGoogleMapData() {
    try {
        let response = await $.get('/map/data?province=' + s_provinsi + '&city=' + s_kota + '&type=' + s_tipe + '&position=' + s_posisi);
        let payload = response['payload'];
        removeMultiMarker();
        if (payload.length > 0) {
            createGoogleMapMarker(payload);
        }

    } catch (e) {
        console.log(e);
    }
}


var multi_marker = [];

function removeMultiMarker() {
    for (i = 0; i < multi_marker.length; i++) {
        multi_marker[i].setMap(null);
    }
}

function createGoogleMapMarker(payload = []) {
    console.log(role);
    var bounds = new google.maps.LatLngBounds();
    payload.forEach(function (v, k) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(v['latitude'], v['longitude']),
            map: map_container,
            icon: v['type']['icon'],
            title: v['name'],
            // label: {
            //     text: v['name'],
            //     className: 'marker-position',
            //     color: "#377D71"
            // }
        });
        multi_marker.push(marker);
        let infowindow = new google.maps.InfoWindow({
            content: windowContent(v, k, role),
        });

        marker.addListener('click', function () {
            infowindow.open({
                anchor: marker,
                map_container,
                shouldFocus: false,
            });

        });
        bounds.extend(marker.position);
    });
    map_container.fitBounds(bounds);

}

function windowContent(data, key, role = 'presence') {

    let vendor = '-';
    if (data['vendor_all'] !== null) {
        vendor = data['vendor_all']['name'];
    }

    let vendorElement = '';
    if (role !== 'presence') {
        vendorElement = '<p>Vendor : <span class="fw-bold">' + vendor + '</span></p>';
    }
    return '<div>' +
        '<p class="fw-bold">' + data['location'] + '</p>' +
        '<p>' + data['address'] + '</p>' + vendorElement +
        '<a onclick="openDetail(this)"  href="#" style="font-size: 10px;" class="btn-detail-item" data-id="' + data['id'] + '">Lihat Detail</a>' +
        '</div>';

}

async function openDetail(element) {
    event.preventDefault()
    let id = element.dataset.id;
    await generateSingleGoogleMapData(id);
    $('#simple-modal-detail').modal('show');
}

async function generateSingleGoogleMapData(id) {
    try {
        let payload = id;

        if (typeof id == 'string'){
            let response = await $.get('/map/data/' + id);
            payload = response.payload;
        }else{
            const url = await getUrl(id.id);
            payload.url = url;
        }

        console.log(payload['latitude'] + typeof payload['latitude'], payload['longitude']);
        const location = {lat: payload['latitude'], lng: payload['longitude']};
        map_container_single = new google.maps.Map(document.getElementById("single-map-container"), {
            zoom: 16,
            center: location,
        });
        new google.maps.Marker({
            position: new google.maps.LatLng(payload['latitude'], payload['longitude']),
            map: map_container_single,
            icon: payload['type']['icon'],
            title: payload['name'],
        });
        generateDetail(payload);
    } catch (e) {
        console.log(e);
    }
}

function generateDetail(data) {
    $('#detail-title-tipe').html(data['type']['name']);
    $('#detail-title-nama').html('( ' + data['name'] + ' )');
    $('#single-map-container-street-view').html(data['url']);
    $('#detail-vendor').val(data['vendor_all']['name']+' ('+data['vendor_all']['brand']+')');
    $('#detail-vendor-address').val(data['vendor_all']['address']);
    $('#detail-vendor-email').val(data['vendor_all']['email']);
    $('#detail-vendor-phone').val(data['vendor_all']['phone']);
    $('#detail-vendor-phone-pic').val(data['vendor_all']['picPhone']);
    $('#detail-vendor-pic').val(data['vendor_all']['picName']);
    $('#detail-provinsi').val(data['city']['province']['name']);
    $('#detail-kota').val(data['city']['name']);
    $('#detail-alamat').val(data['address']);
    $('#detail-lokasi').val(data['location']);
    $('#detail-coordinate').val(data['latitude'] + ', ' + data['longitude']);
    $('#detail-tipe').val(data['type']['name']);
    $('#detail-posisi').val(data['position']);
    $('#detail-panjang').val(data['height']);
    $('#detail-lebar').val(data['width']);
    $('#detail-qty').val(data['qty']);
    $('#detail-side').val(data['side']);
    $('#detail-trafic').val(data['trafic']);
    $('#single-map-container-street-view').html(data['url']);
    $('#detail-gambar-1').attr('src', data['image1']);
    $('#detail-gambar-2').attr('src', data['image2']);
    $('#detail-gambar-3').attr('src', data['image3']);
    $('#link-gbr1').attr('href', data['image3']);
    $('#dwnld-gbr1').attr('href', data['image3']);
    $('#dwnld-gbr1').attr('download', data['image3']);
    $('#link-gbr2').attr('href', data['image3']);
    $('#dwnld-gbr2').attr('href', data['image3']);
    $('#dwnld-gbr2').attr('download', data['image3']);
    $('#link-gbr3').attr('href', data['image3']);
    $('#dwnld-gbr3').attr('href', data['image3']);
    $('#dwnld-gbr3').attr('download', data['image3']);
}
