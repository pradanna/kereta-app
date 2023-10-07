<div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahuser">Tambah Titik Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" enctype="multipart/form-data">
                    @csrf
                    <input id="id" name="id" hidden>
                    <div class="row mb-3">
                        <div class="col-md-3 col-sm-12">
                            <label for="name" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Kode">

                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="vendor" class="form-label">Vendor</label>
                            <select class="form-select mb-3 w-full" style="width: 100%" id="vendor" name="vendor_id"
                                required>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="province" class="form-label">Provinsi</label>
                            <select class="form-select mb-3 w-full" style="width: 100%" id="province" required>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="city" class="form-label">Kota</label>
                            <select class="form-select mb-3" style="width: 100%" id="city" name="city_id" required>
                                <option>Pilih Data</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Alamat"
                            required>
                        <label for="alamat" class="form-label">Alamat</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="location" name="location" placeholder="Lokasi"
                            required>
                        <label for="location" class="form-label">Lokasi</label>
                    </div>


                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="urlstreetview" name="url" required
                            placeholder="urlstreetview">
                        <label for="urlstreetview" class="form-label">URL Street View</label>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="latlong" name="latlong" required
                                    placeholder="latitude dan longtitude">
                                <label for="latitude" class="form-label">Latitude & Longtitude (e.g. -123141234, 839214813)</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="type" class="form-label">Tipe</label>
                            <select class="form-select mb-3 selectType" aria-label="Default select example"
                                id="type" required name="type_id">
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="position" class="form-label">Posisi</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="position" required
                                name="position">
                                <option value="" selected>Pilih Posisi</option>
                                <option value="Horizontal">Horizontal</option>
                                <option value="Vertical">Vertical</option>
                            </select>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="qty" type="number" name="qty"
                                    placeholder="0">
                                <label for="qty" class="form-label">Qty</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="side" name="side"
                                    placeholder="lebar">
                                <label for="side" class="form-label">Side</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="trafic" name="trafic"
                                    placeholder="lebar">
                                <label for="trafic" class="form-label">Trafik</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="height" type="text" name="height"
                                    placeholder="0">
                                <label for="height" class="form-label">Panjang/Tinggi</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="width" name="width"
                                    placeholder="lebar">
                                <label for="width" class="form-label">Lebar</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="gambar1" class="form-label">Gambar Vendor</label>
                                <input type="file" id="image1" name="" class="image"
                                    data-min-height="10" data-heigh="400" accept="image/jpeg, image/jpg, image/png"
                                    data-allowed-file-extensions="jpg jpeg png" />
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="gambar2" class="form-label">Gambar Template</label>
                                <input type="file" id="image2" name="" class="image"
                                    data-min-height="10" data-heigh="400" accept="image/jpeg, image/jpg, image/png"
                                    data-allowed-file-extensions="jpg jpeg png" />
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="gambar3" class="form-label">Gambar Yousee</label>
                                <input type="file" id="image3" name="" class="image"
                                    data-min-height="10" data-heigh="400" accept="image/jpeg, image/jpg, image/png"
                                    data-allowed-file-extensions="jpg jpeg png" />
                            </div>
                        </div>
                    </div>
                    <div class="my-3">
                        <div class="d-flex">
                            <button type="submit" class="btn-utama"
                                style="width: 100%; justify-content: center">Simpan
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Detail-->
<div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="modaldetail" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Titik ( <span id="d-name"></span> )</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-pills mb-3" id="pills-tab-detail" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link genostab active" id="pills-detail-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-detail" type="button" role="tab"
                            aria-controls="pills-detail" aria-selected="true">Detail
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link genostab" id="pills-maps-tab-detail" data-bs-toggle="pill"
                            data-bs-target="#pills-maps" type="button" role="tab" aria-controls="pills-maps"
                            aria-selected="false">Maps
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link genostab" id="pills-gambar1-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-gambar1" type="button" role="tab"
                            aria-controls="pills-gambar1" aria-selected="false">Gambar Vendor
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link genostab" id="pills-gambar2-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-gambar2" type="button" role="tab"
                            aria-controls="pills-gambar2" aria-selected="false">Gambar Template
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link genostab" id="pills-gambar3-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-gambar3" type="button" role="tab"
                            aria-controls="pills-gambar3" aria-selected="false">Gambar Yousee
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-detail" role="tabpanel"
                        aria-labelledby="pills-detail-tab">
                        <div class="row">
                            <input type="hidden" id="d-id" name="d-id">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-Vendor" name="d-Vendor"
                                        disabled placeholder="Vendor">
                                    <label for="d-Vendor" class="form-label">Vendor</label>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-provinsi" name="d-provinsi"
                                        disabled placeholder="Provinsi">
                                    <label for="d-provinsi" class="form-label">Provinsi</label>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-kota" name="d-kota"
                                        disabled placeholder="Kota">
                                    <label for="d-kota" class="form-label">Kota</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="d-alamat" name="d-alamat" disabled
                                placeholder="alamat">
                            <label for="d-alamat" class="form-label">Alamat</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="d-lokasi" name="d-lokasi" disabled
                                placeholder="lokasi">
                            <label for="d-lokasi" class="form-label">Lokasi</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="d-urlstreetview" name="d-urlstreetview"
                                disabled placeholder="urlstreetview">
                            <label for="d-urlstreetview" class="form-label">URL Street View</label>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-latlong" name="d-panjang"
                                        disabled placeholder="latlong">
                                    <label for="d-panjang" class="form-label">Latitude & Longtitude</label>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-tipe" name="d-tipe"
                                        disabled placeholder="tipe">
                                    <label for="d-tipe" class="form-label">Tipe</label>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-posisi" name="d-posisi"
                                        disabled placeholder="posisi">
                                    <label for="d-posisi" class="form-label">Posisi</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-panjang" type="number"
                                        disabled name="d-panjang" placeholder="0">
                                    <label for="d-panjang" class="form-label">Panjang/Tinggi</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="d-lebar" name="d-lebar"
                                        disabled placeholder="0">
                                    <label for="d-lebar" class="form-label">Lebar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-maps" role="tabpanel" aria-labelledby="pills-maps-tab">
                        <div class="panel-peta mb-3" id="map-detail">
                            Tampil Peta

                        </div>

                        <div class="panel-streetview" style="display: flex;justify-content: center;width: 100%;">
                            {{-- <div class="panel"> --}}
                            {{-- <div id="map"></div> --}}
                            {{-- </div> --}}
                            <div class="gmap_canvas" id="panel-street"
                                style="align-items: center;display: flex;flex: 1;">

                            </div>

                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-gambar1" role="tabpanel"
                        aria-labelledby="pills-gambar1-tab">
                        <a class="btn-success-soft sml rnd" id="downlodShowImg1"><i
                                class="material-symbols-outlined menu-icon">download</i>Download</a>
                        <div class="panel-gambar" id="showImg1">
                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-gambar2" role="tabpanel"
                        aria-labelledby="pills-gambar2-tab">
                        <a class="btn-success-soft sml rnd" id="downlodShowImg2"><i
                                class="material-symbols-outlined menu-icon">download</i>Download</a>

                        <div class="panel-gambar" id="showImg2">
                        </div>

                    </div>

                    <div class="tab-pane fade" id="pills-gambar3" role="tabpanel"
                        aria-labelledby="pills-gambar3-tab">
                        <a class="btn-success-soft sml rnd" id="downlodShowImg3"><i
                                class="material-symbols-outlined menu-icon">download</i>Download</a>

                        <div class="panel-gambar" id="showImg3">
                        </div>

                    </div>
                </div>


            </div>


        </div>
    </div>
</div>


<div class="modal fade" id="modalHistory" tabindex="-1" aria-labelledby="modaltambahtitik" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaltambahuser">History Update <span id="titleHistory"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table">
                    <tr>
                        <th>#</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                    <tbody id="bodyHistory"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="simple-modal-detail" tabindex="-1" aria-labelledby="simple-modal-detail"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down" style="min-height: 900px !important;">
        <div class="modal-content ps-3 pe-3 pb-3 pt-3" style="min-height: 900px !important;">
            <p class="fw-bold">Detail <span id="detail-title-tipe"></span> <span id="detail-title-nama"></span></p>
            <div class="d-flex">
                <div class="w-50">
                    <div id="single-map-container" style="width: 100%"></div>
                    <div id="single-map-container-street-view"
                        class="d-flex align-items-center justify-content-center mt-2"
                        style="height: 450px; border: 1px darkgray solid; border-radius: 10px">
                        <div class="fw-bold">Street View Container</div>
                    </div>
                </div>

                <div id="single-map-container-information" class="ms-2 w-50">
                    <ul class="nav nav-pills mb-3" id="pills-single-tab-detail" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link genostab-custom active" id="pills-single-detail-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-single-detail" type="button"
                                role="tab" aria-controls="pills-single-detail" aria-selected="true">Detail
                            </button>
                        </li>
                        @if (auth()->user()->role != 'presence')
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab-custom" id="pills-single-gambar1-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-single-gambar1" type="button"
                                    role="tab" aria-controls="pills-single-gambar1" aria-selected="false">Gambar
                                    Vendor
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link genostab-custom" id="pills-single-gambar2-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-single-gambar2" type="button"
                                    role="tab" aria-controls="pills-single-gambar2" aria-selected="false">Gambar
                                    Template
                                </button>
                            </li>
                        @endif
                        <li class="nav-item" role="presentation">
                            <button class="nav-link genostab-custom" id="pills-single-gambar3-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-single-gambar3" type="button"
                                role="tab" aria-controls="pills-single-gambar3" aria-selected="false">Gambar
                                Yousee
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-single-tabContent">
                        <div class="tab-pane fade show active" id="pills-single-detail" role="tabpanel"
                            aria-labelledby="pills-single-detail-tab">
                            @if (auth()->user()->role != 'presence')
                                <div class="form-floating mb-3 w-100">
                                    <input type="text" class="form-control" id="detail-vendor"
                                        name="detail-vendor" readonly="readonly" placeholder="Vendor">
                                    <label for="detail-vendor" class="form-label">Vendor</label>
                                </div>
                                <div class="form-floating mb-3 w-100">
                                    <input type="text" class="form-control" id="detail-vendor-address"
                                        name="detail-vendor-address" readonly="readonly" placeholder="Vendor">
                                    <label for="detail-vendor-address" class="form-label">Alamat Vendor</label>
                                </div>
                                <div class="form-floating mb-3 w-100">
                                    <input type="text" class="form-control" id="detail-vendor-email"
                                        name="detail-vendor-email" readonly="readonly" placeholder="Vendor">
                                    <label for="detail-vendor-email" class="form-label">Email Vendor</label>
                                </div>
                                <div class="form-floating mb-3 w-100">
                                    <input type="text" class="form-control" id="detail-vendor-phone"
                                        name="detail-vendor-phone" readonly="readonly" placeholder="Vendor">
                                    <label for="detail-vendor-phone" class="form-label">Nomor Vendor (Kantor)</label>
                                </div>
                                <div class="form-floating mb-3 w-100">
                                    <input type="text" class="form-control" id="detail-vendor-pic"
                                        name="detail-vendor-pic" readonly="readonly" placeholder="Vendor">
                                    <label for="detail-vendor-pic" class="form-label">Nama PIC</label>
                                </div>
                                <div class="form-floating w-100">
                                    <input type="text" class="form-control" id="detail-vendor-phone-pic"
                                        name="detail-vendor-phone-pic" readonly="readonly" placeholder="Vendor">
                                    <label for="detail-vendor-phone-pic" class="form-label">Nomor PIC</label>
                                </div>
                                <div class="my-3" style="border-bottom: 1px solid gray"></div>
                            @endif
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-provinsi"
                                            name="detail-provinsi" readonly="readonly" placeholder="Provinsi">
                                        <label for="detail-provinsi" class="form-label">Provinsi</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-kota"
                                            name="detail-kota" readonly="readonly" placeholder="Kota">
                                        <label for="detail-kota" class="form-label">Kota</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3 w-100">
                                <textarea rows="3" class="form-control" id="detail-alamat" name="detail-alamat" readonly="readonly"
                                    placeholder="Alamat" style="height: 100px"></textarea>
                                <label for="detail-alamat" class="form-label">Alamat</label>
                            </div>
                            <div class="form-floating mb-3 w-100">
                                <textarea rows="3" class="form-control" id="detail-lokasi" name="detail-lokasi" readonly="readonly"
                                    placeholder="Lokasi" style="height: 100px"></textarea>
                                <label for="detail-lokasi" class="form-label">Lokasi</label>
                            </div>
                            <div class="form-floating mb-3 w-100">
                                <input type="text" class="form-control" id="detail-coordinate"
                                    name="detail-coordinate" readonly="readonly" placeholder="Koordinat">
                                <label for="detail-coordinate" class="form-label">Koordinat</label>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-tipe"
                                            name="detail-tipe" readonly="readonly" placeholder="Tipe">
                                        <label for="detail-tipe" class="form-label">Tipe</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-qty"
                                            name="detail-posisi" readonly="readonly" placeholder="Posisi">
                                        <label for="detail-qty" class="form-label">Qty</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-side"
                                            name="detail-side" readonly="readonly" placeholder="Posisi">
                                        <label for="detail-side" class="form-label">Side</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-posisi"
                                            name="detail-posisi" readonly="readonly" placeholder="Posisi">
                                        <label for="detail-posisi" class="form-label">Posisi</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-panjang"
                                            name="detail-panjang" readonly="readonly" placeholder="Panjang/Tinggi">
                                        <label for="detail-panjang" class="form-label">Panjang/Tinggi</label>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-lebar"
                                            name="detail-lebar" readonly="readonly" placeholder="Lebar">
                                        <label for="detail-lebar" class="form-label">Lebar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-floating mb-3 w-100">
                                        <input type="text" class="form-control" id="detail-trafic"
                                            name="detail-trafic" readonly="readonly" placeholder="trafic">
                                        <label for="detail-trafic" class="form-label">Trafik / Day</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="pills-single-gambar1" role="tabpanel"
                            aria-labelledby="pills-single-gambar1-tab">
                            <div style="position: relative">
                                <a id="link-gbr1" target="_blank"><img id="detail-gambar-1" src=""
                                        alt="Gambar-1" style="width: 100%"></a>
                                <a class="btn-utama flex " id="dwnld-gbr1"
                                    style="position: absolute; right: 10px; top: 10px">Download <i
                                        class="ms-2 material-symbols-outlined menu-icon">download</i></a>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="pills-single-gambar2" role="tabpanel"
                            aria-labelledby="pills-single-gambar2-tab">
                            <div style="position: relative">
                                <a id="link-gbr2" target="_blank"><img id="detail-gambar-2" src=""
                                        alt="Gambar-2" style="width: 100%"></a>
                                <a class="btn-utama flex " id="dwnld-gbr2"
                                    style="position: absolute; right: 10px; top: 10px">Download <i
                                        class="ms-2 material-symbols-outlined menu-icon">download</i></a>
                            </div>


                        </div>
                        <div class="tab-pane fade show" id="pills-single-gambar3" role="tabpanel"
                            aria-labelledby="pills-single-gambar3-tab">
                            <div style="position: relative">
                                <a id="link-gbr3" target="_blank"><img id="detail-gambar-3" src=""
                                        alt="Gambar-3" style="width: 100%"></a>
                                <a class="btn-utama flex " id="dwnld-gbr3"
                                    style="position: absolute; right: 10px; top: 10px">Download <i
                                        class="ms-2 material-symbols-outlined menu-icon">download</i></a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
