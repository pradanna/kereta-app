@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">DAERAH RAWAN BENCANA {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Daerah Rawan Bencana {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daerah Rawan
                    Bencana {{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="resort-option" class="form-label d-none">Resort</label>
                            <select class="select2 form-control" name="resort-option" id="resort-option"
                                    style="width: 100%;">
                                <option value="">Semua Resort</option>
                                @foreach ($resorts as $resort)
                                    <option value="{{ $resort->id }}">{{ $resort->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="location-type-option" class="form-label d-none">Lokasi</label>
                            <select class="select2 form-control" name="location-type-option" id="location-type-option"
                                    style="width: 100%;">
                                <option value="">Semua Lokasi</option>
                                <option value="0">Jalan Rel</option>
                                <option value="1">Jembatan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#" style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Daerah Rawan Bencana</p>
            <div class="d-flex align-item-center">
                @if($access['is_granted_create'])
                    <a class="btn-utama sml rnd me-2"
                       href="{{ route('means.disaster-area.service-unit.add', ['service_unit_id' => $service_unit->id]) }}">Tambah
                        <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                    </a>
                @endif
                <a class="btn-success sml rnd" href="#" id="btn-export"
                   target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <div class="d-flex align-items-center mb-3">
                <div class="flex-grow-1">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active d-flex align-items-center" id="pills-table-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-table" type="button" role="tab" aria-controls="pills-table"
                                    aria-selected="true">
                                <i class="material-symbols-outlined me-1" style="font-size: 14px; color: inherit">view_list</i>
                                Data
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center" id="pills-map-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-map" type="button" role="tab"
                                    aria-controls="pills-map" aria-selected="false">
                                <i class="material-symbols-outlined me-1"
                                   style="font-size: 14px; color: inherit">public</i>
                                Peta
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-table" role="tabpanel"
                     aria-labelledby="pills-table-tab">
                    <table id="table-data" class="display table table-striped w-100">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="10%" class="text-center">Wilayah</th>
                            <th width="10%" class="text-center">Lintas</th>
                            <th width="10%" class="text-center">Petak</th>
                            <th width="15%" class="text-center">Resort</th>
                            <th width="10%" class="text-center">Lokasi</th>
                            <th width="10%" class="text-center">KM/HM</th>
                            <th class="text-center">Jenis Rawan</th>
                            <th class="text-center middle-header" width="8%">Gambar</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
                    <div id="main-map" style="width: 100%; height: calc(100vh - 70px); border-radius: 10px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-detail-certification" tabindex="-1" aria-labelledby="modal-detail-certification"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Daerah Rawan
                        Bencana</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="area" class="form-label">Wilayah</label>
                                <input type="text" class="form-control" name="area" id="area" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="track" class="form-label">Lintas</label>
                                <input type="text" class="form-control" name="track" id="track" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="sub_track" class="form-label">Petak</label>
                                <input type="text" class="form-control" name="sub_track" id="sub_track" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="resort" class="form-label">Resort</label>
                                <input type="text" class="form-control" name="resort" id="resort" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="location_type" class="form-label">Lokasi</label>
                                <input type="text" class="form-control" name="location_type" id="location_type"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="disaster_type" class="form-label">Jenis Rawan</label>
                                <input type="text" class="form-control" name="disaster_type" id="disaster_type"
                                       disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="block" class="form-label">KM/HM</label>
                                <input type="text" step="any" class="form-control" id="block"
                                       name="block"
                                       placeholder="KM" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="lane" class="form-label">Jalur</label>
                                <input type="text" step="any" class="form-control" id="lane"
                                       name="lane"
                                       placeholder="Jalur" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="number" step="any" class="form-control" id="latitude" name="latitude"
                                       placeholder="Contoh: 7.1129489" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="number" step="any" class="form-control" id="longitude" name="longitude"
                                       placeholder="Contoh: 110.1129489" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="handling" class="form-label">Penanganan</label>
                                <textarea rows="3" class="form-control" id="handling" name="handling"
                                          disabled></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" id="description" name="description"
                                          disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="{{ asset('js/map-control.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';
        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));
        let grantedUpdate = '{{ $access['is_granted_update'] }}';
        let grantedDelete = '{{ $access['is_granted_delete'] }}';

        function changeTabEvent() {
            $("#pills-tab").on("shown.bs.tab", function (e) {
                if (e.target.id === "pills-table-tab") {
                    table.columns.adjust();
                }
                if (e.target.id === "pills-map-tab") {
                    generateMapDisasterArea();
                }
            })
        }

        function getDataDisasterAreaMap() {
            let service_unit = $('#service-unit-option').val();
            let resort = $('#resort-option').val();
            let location_type = $('#location-type-option').val();
            let url = path + '?type=map&service_unit=' + service_unit + '&resort=' + resort + '&location_type=' + location_type;
            return $.get(url)
        }

        function generateMapDisasterArea() {
            getDataDisasterAreaMap().then((response) => {
                console.log(response);
                removeMultiMarker();
                let data = response.data;
                if (data.length > 0) {
                    createMultiMarkerDisasterArea(data)
                }
            }).catch((e) => {
                console.log(e)
            })
        }

        function deleteEvent() {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        destroy(id);
                    }
                });

            })
        }

        function destroy(id) {
            let url = path + '/' + id + '/delete';
            AjaxPost(url, {}, function () {
                SuccessAlert('Success', 'Berhasil Menghapus Data...').then(() => {
                    table.ajax.reload();
                    generateMapDisasterArea();
                });
            });
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                detailHandler(id);
            });
        }

        async function detailHandler(id) {
            try {
                let url = path + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let resort = data['resort']['name'];
                let area = data['area']['name'];
                let track = data['track']['code'];
                let subTrack = data['sub_track']['code'];
                let locationType = data['location_type'];
                let disasterType = data['disaster_type']['name'];
                let block = data['block'];
                let lane = data['lane'];
                let latitude = data['latitude'];
                let longitude = data['longitude'];
                let handling = data['handling'];
                let description = data['description'];
                let locationTypeValue = '-';
                switch (locationType) {
                    case 0:
                        locationTypeValue = 'Jalan Rel';
                        break;
                    case 1:
                        locationTypeValue = 'Jembatan';
                        break;
                    default:
                        break;
                }
                $('#area').val(area);
                $('#track').val(track);
                $('#resort').val(resort);
                $('#sub_track').val(subTrack);
                $('#location_type').val(locationTypeValue);
                $('#disaster_type').val(disasterType);
                $('#lane').val(lane);
                $('#block').val(block);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                $('#handling').val(handling);
                $('#description').val(description);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }


        $(document).ready(function () {
            changeTabEvent();
            $('.select2').select2({
                width: 'resolve',
            });
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.resort = $('#resort-option').val();
                        d.location_type = $('#location-type-option').val();
                        d.type = 'table';
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center middle-header',
                },
                    {
                        data: 'area.name',
                        name: 'area.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'track.code',
                        name: 'track.code',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'resort.name',
                        name: 'resort.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'location_type',
                        name: 'location_type',
                        className: 'text-center middle-header',
                        render: function (data) {
                            let value = '-';
                            switch (data) {
                                case 0:
                                    value = 'Jalan Rel';
                                    break;
                                case 1:
                                    value = 'Jembatan';
                                    break;
                                default:
                                    break;
                            }
                            return value;
                        }
                    },
                    {
                        data: 'block',
                        name: 'block',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'disaster_type.name',
                        name: 'disaster_type.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let url = path + '/' + data['id'] + '/gambar';
                            return '<a href="' + url + '" class="btn-image btn-table-action">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            let elEdit = grantedUpdate === '1' ? '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' : '';
                            let elDelete = grantedDelete === '1' ? '<a href="#" class="btn-delete btn-table-action" data-id="' + data[
                                'id'] + '">Delete</a>' : '';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' +
                                data['id'] + '">Detail</a>' + elEdit + elDelete
                        },
                        orderable: false,
                        className: 'text-center middle-header',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
                dom: 'ltrip'
            });

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-export').on('click', function (e) {
                e.preventDefault();
                let resort = $('#resort-option').val();
                let locationType = $('#location-type-option').val();
                let queryParam = '?resort=' + resort + '&location_type=' + locationType;
                let exportPath = path + '/excel' + queryParam;
                window.open(exportPath, '_blank');
            });
        })
    </script>
@endsection
