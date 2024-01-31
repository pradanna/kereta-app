var map_container;
var map_container_single;
var center_indonesia = {
    lat: -0.4029326,
    lng: 110.5938779,
};

function initMap() {
    const myLatLng = {lat: -6.979141065839643, lng: 110.41708469206758};
    map_container = new google.maps.Map(document.getElementById("main-map"), {
        zoom: 9,
        center: myLatLng,
    });
}

async function generateGoogleMapData() {
    try {
        let response = await $.get(
            "/map/data?province=" +
            s_provinsi +
            "&city=" +
            s_kota +
            "&type=" +
            s_tipe +
            "&position=" +
            s_posisi
        );
        let payload = response["payload"];
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

function createMultiMarkerServiceUnit(data = []) {
    var bounds = new google.maps.LatLngBounds();
    data.forEach(function (v, k) {
        let areaMarker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: "/images/marker/electric-train.png",
            title: v["name"],
        });
        multi_marker.push(areaMarker);
        let infoWindow = new google.maps.InfoWindow({
            content: windowContentServiceUnitMarker(v),
        });

        areaMarker.addListener("click", function () {
            infoWindow.open({
                anchor: areaMarker,
                map_container,
                shouldFocus: false,
            });
        });

        bounds.extend(areaMarker.position);
    });

    map_container.fitBounds(bounds);
}

function createMultiMarkerArea(data = []) {
    var bounds = new google.maps.LatLngBounds();
    data.forEach(function (v, k) {
        let areaMarker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: "/images/marker/electric-train.png",
            title: v["name"],
        });
        multi_marker.push(areaMarker);
        let infoWindow = new google.maps.InfoWindow({
            content: windowContentAreaMarker(v),
        });
        areaMarker.addListener("click", function () {
            infoWindow.open({
                anchor: areaMarker,
                map_container,
                shouldFocus: false,
            });
        });
        bounds.extend(areaMarker.position);
    });

    map_container.fitBounds(bounds);
}

//multi marker for Direct Passage
function createMultiMarkerDirectPassage(data = []) {
    var bounds = new google.maps.LatLngBounds();
    data.forEach(function (v, k) {
        let areaMarker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: "/images/marker/custom-marker.png",
            title: v["name"],
        });
        multi_marker.push(areaMarker);
        let infoWindow = new google.maps.InfoWindow({
            content: windowContentDirectPassageMarker(v),
        });
        areaMarker.addListener("click", function () {
            infoWindow.open({
                anchor: areaMarker,
                map_container,
                shouldFocus: false,
            });
        });
        bounds.extend(areaMarker.position);
    });

    map_container.fitBounds(bounds);
}

function createMultiMarkerDisasterArea(data = []) {
    var bounds = new google.maps.LatLngBounds();
    data.forEach(function (v, k) {
        let areaMarker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: "/images/marker/custom-marker.png",
            title: v["name"],
        });
        multi_marker.push(areaMarker);
        let infoWindow = new google.maps.InfoWindow({
            content: windowContentDisasterAreaMarker(v),
        });
        areaMarker.addListener("click", function () {
            infoWindow.open({
                anchor: areaMarker,
                map_container,
                shouldFocus: false,
            });
        });
        bounds.extend(areaMarker.position);
    });

    map_container.fitBounds(bounds);
}

//multi marker for service unit or SATPEL
function windowContentServiceUnitMarker(data) {
    return (
        '<div class="p-1" style="width: 200px;">' +
        '<p class="mb-3 text-center" style="color: #777777; font-size: 14px; font-weight: bold;">' +
        data["name"] +
        "</p>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<a href="#" onclick="goToFacilityPage(this)" class="d-flex align-items-center btn-facility" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">card_membership</span>' +
        '<span style="color: #777777; font-size: 12px;">Sertifikasi Sarana</span>' +
        "</a>" +
        "</div>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<a href="#" onclick="goToDirectPassagePage(this)" class="d-flex align-items-center btn-direct-passage" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">timeline</span>' +
        '<span style="color: #777777; font-size: 12px;">Jalur Perlintasan Langsung</span>' +
        "</a>" +
        "</div>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<a href="#" onclick="goToDisasterAreaPage(this)" class="d-flex align-items-center btn-disaster" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">flood</span>' +
        '<span style="color: #777777; font-size: 12px;">Daerah Rawan Bencana</span>' +
        "</a>" +
        "</div>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<a href="#" onclick="goToIllegalBuildingPage(this)" class="d-flex align-items-center btn-disaster" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">domain</span>' +
        '<span style="color: #777777; font-size: 12px;">Bangunan Liar</span>' +
        "</a>" +
        "</div>" +
        "</div>"
    );
}

//multi marker for material tool
function createMultiMarkerMaterialTool(data = []) {
    var bounds = new google.maps.LatLngBounds();
    data.forEach(function (v, k) {
        let areaMarker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: "/images/marker/custom-marker.png",
            title: v["name"],
        });
        multi_marker.push(areaMarker);
        let infoWindow = new google.maps.InfoWindow({
            content: windowContentMaterialToolMarker(v),
        });
        areaMarker.addListener("click", function () {
            infoWindow.open({
                anchor: areaMarker,
                map_container,
                shouldFocus: false,
            });
        });
        bounds.extend(areaMarker.position);
    });

    map_container.fitBounds(bounds);
}

//multi marker for illegal building
function createMultiMarkerIllegalBuilding(data = []) {
    var bounds = new google.maps.LatLngBounds();
    data.forEach(function (v, k) {
        let areaMarker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: "/images/marker/custom-marker.png",
            title: v["name"],
        });
        multi_marker.push(areaMarker);
        let infoWindow = new google.maps.InfoWindow({
            content: windowContentIllegalBuildingMarker(v),
        });
        areaMarker.addListener("click", function () {
            infoWindow.open({
                anchor: areaMarker,
                map_container,
                shouldFocus: false,
            });
        });
        bounds.extend(areaMarker.position);
    });

    map_container.fitBounds(bounds);
}

//multimarker for area or DAOP
function windowContentAreaMarker(data) {
    return (
        '<div class="p-1" style="width: 200px;">' +
        '<p class="mb-1 text-center" style="color: #777777; font-size: 14px; font-weight: bold;">' +
        data["name"] +
        "</p>" +
        '<p class="mb-3 text-center" style="color: #777777; font-size: 12px;">' +
        data["service_unit"]["name"] +
        "</p>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<a href="#" onclick="goToFacilityPage(this)" class="d-flex align-items-center btn-facility" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">card_membership</span>' +
        '<span style="color: #777777; font-size: 12px;">Sertifikasi Sarana</span>' +
        "</a>" +
        "</div>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<a href="#" onclick="goToDirectPassagePage(this)" class="d-flex align-items-center btn-direct-passage" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">timeline</span>' +
        '<span style="color: #777777; font-size: 12px;">Jalur Perlintasan Langsung</span>' +
        "</a>" +
        "</div>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<a href="#" onclick="goToIllegalBuildingPage(this)" class="d-flex align-items-center btn-disaster" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">domain</span>' +
        '<span style="color: #777777; font-size: 12px;">Bangunan Liar</span>' +
        "</a>" +
        "</div>" +
        "</div>"
    );
}

function windowContentDirectPassageMarker(data) {
    return (
        '<div class="p-1" style="width: 250px;">' +
        '<p class="mb-1 text-center" style="color: #777777; font-size: 14px; font-weight: bold;">' +
        data["name"] +
        " (" +
        data["sub_track"]["code"] +
        ")</p>" +
        '<p class="mb-3 text-center" style="color: #777777; font-size: 12px;">' +
        data["track"]["code"] +
        " (" +
        data["area"]["name"] +
        ")</p>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<div class="d-flex align-items-center btn-facility" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">car_crash</span>' +
        '<span style="color: #777777; font-size: 12px;">Peristiwa Luar Biasa Hebat (PLH) (' +
        data["count_accident"] +
        ")</span>" +
        "</div>" +
        "</div>" +
        // '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        // '<div class="d-flex align-items-center btn-facility" data-id="' +
        // data["id"] +
        // '" style="text-decoration: none;">' +
        // '<span class="material-symbols-outlined menu-icon me-1" style="color: #777777; font-size: 10px;">engineering</span>' +
        // '<span style="color: #777777; font-size: 12px;">Penjaga Jalur Lintasan (' +
        // data["count_guard"] +
        // ")</span>" +
        // "</div>" +
        // "</div>" +
        "</div>"
    );
}

function windowContentDisasterAreaMarker(data) {
    return (
        '<div class="p-1" style="width: 200px;">' +
        '<p class="mb-1 text-center" style="color: #777777; font-size: 14px; font-weight: bold;">' +
        data["resort"]["name"] +
        " (" +
        data["sub_track"]["code"] +
        ")</p>" +
        '<p class="mb-3 text-center" style="color: #777777; font-size: 12px;">' +
        data["block"] +
        "</p>" +
        "</div>"
    );
}

function windowContentMaterialToolMarker(data) {
    return '<div class="p-1" style="width: 200px;">' +
        '<p class="mb-1 text-center" style="color: #777777; font-size: 14px; font-weight: bold;">' + data['resort']['name'] +
        ' (' + data['stakes'] + ')</p>' +
        '<p class="mb-3 text-center" style="color: #777777; font-size: 12px;">' + data["type"] + ' (' + data['qty'] + ') ' + data['unit'] +
        '</p>' +
        '</div>';
}

function windowContentIllegalBuildingMarker(data) {
    return '<div class="p-1" style="width: 200px;">' +
        '<p class="mb-1 text-center" style="color: #777777; font-size: 14px; font-weight: bold;">' + data['district']['name'] + '</p>' +
        '<p class="mb-3 text-center" style="color: #777777; font-size: 12px;">' + data['stakes'] +
        '</p>' +
        '</div>';
}

async function goToFacilityPage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/sertifikasi-sarana";
    window.open(url, "_blank");
}

async function goToDirectPassagePage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/jalur-perlintasan-langsung";
    window.open(url, "_blank");
}

async function goToDirectPassageGuardPage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/penjaga-jalur-lintasan";
    window.open(url, "_blank");
}

async function goToDisasterAreaPage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/daerah-rawan-bencana";
    window.open(url, "_blank");
}

async function goToIllegalBuildingPage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/bangunan-liar";
    window.open(url, "_blank");
}

function createMultiMarkerStorehouse(data = []) {
    var bounds = new google.maps.LatLngBounds();
    data.forEach(function (v, k) {
        let areaMarker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: v["storehouse_type"]["marker_icon"],
            title: v["name"],
        });
        multi_marker.push(areaMarker);
        let infoWindow = new google.maps.InfoWindow({
            content: windowContentStorehouseMarker(v),
        });
        areaMarker.addListener("click", function () {
            infoWindow.open({
                anchor: areaMarker,
                map_container,
                shouldFocus: false,
            });
        });
        bounds.extend(areaMarker.position);
    });
    map_container.fitBounds(bounds);
}

function windowContentStorehouseMarker(data) {
    return (
        '<div class="p-1" style="width: 200px;">' +
        '<p class="mb-1 text-center" style="color: #777777; font-size: 12px; font-weight: bold;">' +
        data["name"] +
        "</p>" +
        '<p class="mb-3 text-center" style="color: #777777; font-size: 12px;">' +
        data["storehouse_type"]["name"] +
        " (" +
        data["area"]["name"] +
        ")</p>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<div class="d-flex align-items-center btn-facility" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span style="color: #777777; font-size: 12px;">Lokomotif (' +
        data["count_locomotive"] +
        ")</span>" +
        "</div>" +
        "</div>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<div class="d-flex align-items-center btn-facility" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span style="color: #777777; font-size: 12px;">Kereta (' +
        data["count_train"] +
        ")</span>" +
        "</div>" +
        "</div>" +
        '<div class="w-100 d-flex align-items-center justify-content-center mb-1">' +
        '<div class="d-flex align-items-center btn-facility" data-id="' +
        data["id"] +
        '" style="text-decoration: none;">' +
        '<span style="color: #777777; font-size: 12px;">Gerbong (' +
        data["count_wagon"] +
        ")</span>" +
        "</div>" +
        "</div>" +
        "</div>"
    );
}

async function goToFacilityLocomotivePage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/sertifikasi-sarana-lokomotif";
    window.open(url, "_blank");
}

async function goToFacilityTrainPage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/sertifikasi-sarana-kereta";
    window.open(url, "_blank");
}

async function goToFacilityWagonPage(element) {
    event.preventDefault();
    let id = element.dataset.id;
    const url = path + "/" + id + "/sertifikasi-sarana-gerbong";
    window.open(url, "_blank");
}

function createGoogleMapMarker(payload = []) {
    console.log(role);
    var bounds = new google.maps.LatLngBounds();
    payload.forEach(function (v, k) {
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(v["latitude"], v["longitude"]),
            map: map_container,
            icon: v["type"]["icon"],
            title: v["name"],
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

        marker.addListener("click", function () {
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

function windowContent(data, key, role = "presence") {
    let vendor = "-";
    if (data["vendor_all"] !== null) {
        vendor = data["vendor_all"]["name"];
    }

    let vendorElement = "";
    if (role !== "presence") {
        vendorElement =
            '<p>Vendor : <span class="fw-bold">' + vendor + "</span></p>";
    }
    return (
        "<div>" +
        '<p class="fw-bold">' +
        data["location"] +
        "</p>" +
        "<p>" +
        data["address"] +
        "</p>" +
        vendorElement +
        '<a onclick="openDetail(this)"  href="#" style="font-size: 10px;" class="btn-detail-item" data-id="' +
        data["id"] +
        '">Lihat Detail</a>' +
        "</div>"
    );
}

async function openDetail(element) {
    event.preventDefault();
    let id = element.dataset.id;
    await generateSingleGoogleMapData(id);
    $("#simple-modal-detail").modal("show");
}

async function generateSingleGoogleMapData(id) {
    try {
        let payload = id;

        if (typeof id == "string") {
            let response = await $.get("/map/data/" + id);
            payload = response.payload;
        } else {
            const url = await getUrl(id.id);
            payload.url = url;
        }

        console.log(
            payload["latitude"] + typeof payload["latitude"],
            payload["longitude"]
        );
        const location = {lat: payload["latitude"], lng: payload["longitude"]};
        map_container_single = new google.maps.Map(
            document.getElementById("single-map-container"),
            {
                zoom: 16,
                center: location,
            }
        );
        new google.maps.Marker({
            position: new google.maps.LatLng(
                payload["latitude"],
                payload["longitude"]
            ),
            map: map_container_single,
            icon: payload["type"]["icon"],
            title: payload["name"],
        });
        generateDetail(payload);
    } catch (e) {
        console.log(e);
    }
}

function generateDetail(data) {
    $("#detail-title-tipe").html(data["type"]["name"]);
    $("#detail-title-nama").html("( " + data["name"] + " )");
    $("#single-map-container-street-view").html(data["url"]);
    $("#detail-vendor").val(
        data["vendor_all"]["name"] + " (" + data["vendor_all"]["brand"] + ")"
    );
    $("#detail-vendor-address").val(data["vendor_all"]["address"]);
    $("#detail-vendor-email").val(data["vendor_all"]["email"]);
    $("#detail-vendor-phone").val(data["vendor_all"]["phone"]);
    $("#detail-vendor-phone-pic").val(data["vendor_all"]["picPhone"]);
    $("#detail-vendor-pic").val(data["vendor_all"]["picName"]);
    $("#detail-provinsi").val(data["city"]["province"]["name"]);
    $("#detail-kota").val(data["city"]["name"]);
    $("#detail-alamat").val(data["address"]);
    $("#detail-lokasi").val(data["location"]);
    $("#detail-coordinate").val(data["latitude"] + ", " + data["longitude"]);
    $("#detail-tipe").val(data["type"]["name"]);
    $("#detail-posisi").val(data["position"]);
    $("#detail-panjang").val(data["height"]);
    $("#detail-lebar").val(data["width"]);
    $("#detail-qty").val(data["qty"]);
    $("#detail-side").val(data["side"]);
    $("#detail-trafic").val(data["trafic"]);
    $("#single-map-container-street-view").html(data["url"]);
    $("#detail-gambar-1").attr("src", data["image1"]);
    $("#detail-gambar-2").attr("src", data["image2"]);
    $("#detail-gambar-3").attr("src", data["image3"]);
    $("#link-gbr1").attr("href", data["image3"]);
    $("#dwnld-gbr1").attr("href", data["image3"]);
    $("#dwnld-gbr1").attr("download", data["image3"]);
    $("#link-gbr2").attr("href", data["image3"]);
    $("#dwnld-gbr2").attr("href", data["image3"]);
    $("#dwnld-gbr2").attr("download", data["image3"]);
    $("#link-gbr3").attr("href", data["image3"]);
    $("#dwnld-gbr3").attr("href", data["image3"]);
    $("#dwnld-gbr3").attr("download", data["image3"]);
}
