@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">PERLINTASAN KERETA API (JPL) {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Perlintasan Kereta Api (JPL) {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Perlintasan Kereta Api (JPL) {{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="area-option" class="form-label d-none">Daerah Operasi</label>
                            <select class="select2 form-control" name="area-option" id="area-option"
                                    style="width: 100%;">
                                <option value="">Semua Daerah Operasi</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
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
            <p>Data Jalur Perlintasan Langsung (JPL)</p>
            <div class="d-flex align-item-center">
                <a class="btn-utama sml rnd me-2" href="{{ route('means.direct-passage.service-unit.add', ['service_unit_id' => $service_unit->id]) }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
                <a class="btn-success sml rnd" href="#" id="btn-export">Export
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
                            <th class="text-center middle-header" width="5%">#</th>
                            <th class="text-center middle-header" width="10%">Wilayah</th>
                            <th class="text-center middle-header" width="10%">Lintas</th>
                            <th class="text-center middle-header" width="10%">Petak</th>
                            <th class="text-center middle-header" width="8%">KM/HM</th>
                            <th class="text-center middle-header">No. JPL</th>
                            <th class="text-center middle-header" width="8%">Jumlah PLH</th>
                            <th class="text-center middle-header" width="8%">Status</th>
                            <th class="text-center middle-header" width="8%">Gambar</th>
                            <th class="text-center middle-header" width="15%">Aksi</th>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Jalur Perlintasan
                        Langsung</p>
                    <hr>
                    <ul class="nav nav-pills" id="pills-tab-detail" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active d-flex align-items-center" id="pills-information-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-information" type="button" role="tab" aria-controls="pills-information"
                                    aria-selected="true">
                                Informasi utama
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center" id="pills-equipment-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-equipment" type="button" role="tab"
                                    aria-controls="pills-equipment" aria-selected="false">
                                Perlengkapan Rambu
                            </button>
                        </li>
                    </ul>
                    <hr>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-information" role="tabpanel"
                             aria-labelledby="pills-information-tab">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="area" class="form-label">Area</label>
                                        <input type="text" class="form-control" id="area" name="area"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="track" class="form-label">Lintas</label>
                                        <input type="text" class="form-control" id="track" name="track"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="sub_track" class="form-label">Petak</label>
                                        <input type="text" class="form-control" id="sub_track" name="sub_track"
                                               placeholder="JPL"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="stakes" class="form-label">KM/HM</label>
                                        <input type="text" class="form-control" id="stakes" name="stakes" placeholder="KM/HM"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="name" class="form-label">No. JPL</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="JPL"
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="width" class="form-label">Lebar Jalan (m)</label>
                                        <input type="number" step="any" class="form-control" id="width" name="width"
                                               placeholder="0" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_class" class="form-label">Kelas Jalan</label>
                                        <input type="text" class="form-control" id="road_class" name="road_class" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="elevation" class="form-label">Elevasi (derajat)</label>
                                        <input type="text" step="any" class="form-control" id="elevation" name="elevation"
                                               placeholder="0" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_construction" class="form-label">Konstruksi Jalan</label>
                                        <input type="text" class="form-control" id="road_construction"
                                               name="road_construction" placeholder="Konstruksi Jalan" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="city" class="form-label">Kota</label>
                                        <input type="text" class="form-control" id="city" name="city" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="latitude" class="form-label">Latitude</label>
                                        <input type="number" step="any" class="form-control" id="latitude"
                                               name="latitude" placeholder="Contoh: 7.1129489" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="longitude" class="form-label">Longitude</label>
                                        <input type="number" step="any" class="form-control" id="longitude"
                                               name="longitude" placeholder="Contoh: 110.1129489" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="guarded_by" class="form-label">Status Penjagaan</label>
                                        <input type="text" class="form-control" id="guarded_by" name="guarded_by" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="technical_documentation" class="form-label">No. Surat Rekomendasi
                                            Teknis</label>
                                        <input type="text" class="form-control" id="technical_documentation"
                                               name="technical_documentation" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="is_closed" class="form-label">Status JPL</label>
                                        <input type="text" class="form-control" id="is_closed" name="is_closed" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_name" class="form-label">Nama Jalan / Daerah</label>
                                        <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="road_name"
                                                  name="road_name"
                                                  placeholder="Konstruksi Jalan" disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="description"
                                                  name="description"
                                                  placeholder="Keterangan" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-equipment" role="tabpanel"
                             aria-labelledby="pills-equipment-tab">
                        </div>
                    </div>

                    <hr>
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Perlengkapan Rambu</p>
                    <hr>
                    <table id="table-guard" class="display table table-striped w-100">
                        <thead>
                        <tr>
                            <th class="text-center middle-header">Peringatan Membunyikan Suling Lokomotif</th>
                            <th class="text-center middle-header" width="8%">Peringatan Pintu Perlintasan Sebidang
                            </th>
                            <th class="text-center middle-header" width="8%">Peringatan Tanpa Pintu Perlintasan
                                Sebidang
                            </th>
                            <th class="text-center middle-header" width="8%">Peringatan</th>
                            <th class="text-center middle-header" width="8%">Jarak Lokasi Kritis 400m</th>
                            <th class="text-center middle-header" width="8%">Jarak Lokasi Kritis 350m</th>
                            <th class="text-center middle-header" width="8%">Jarak Lokasi Kritis 100m</th>
                            <th class="text-center middle-header" width="8%">Rambu STOP</th>
                            <th class="text-center middle-header" width="8%">Larangan Berjalan</th>
                            <th class="text-center middle-header" width="8%">Larangan Masuk Kendaraan</th>
                            <th class="text-center middle-header" width="8%">Garis Kejut</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td id="locomotive_flute" class="text-center">-</td>
                            <td id="crossing_gate" class="text-center">-</td>
                            <td id="non_crossing_gate" class="text-center">-</td>
                            <td id="warning" class="text-center">-</td>
                            <td id="critical_distance_450" class="text-center">-</td>
                            <td id="critical_distance_300" class="text-center">-</td>
                            <td id="critical_distance_100" class="text-center">-</td>
                            <td id="stop_sign" class="text-center">-</td>
                            <td id="walking_ban" class="text-center">-</td>
                            <td id="vehicle_entry_ban" class="text-center">-</td>
                            <td id="shock_line" class="text-center">-</td>
                        </tr>
                        </tbody>
                    </table>
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
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

        function changeTabEvent() {
            $("#pills-tab").on("shown.bs.tab", function (e) {
                if (e.target.id === "pills-table-tab") {
                    table.columns.adjust();
                }
                if (e.target.id === "pills-map-tab") {
                    generateMapDirectPassage();
                }
            })
        }

        function getDataDirectPassageMap() {
            let area = $('#area-option').val();
            let track = $('#track-option').val();
            let url = path + '?type=map&area=' + area + '&track=' + track;
            return $.get(url)
        }

        function generateMapDirectPassage() {
            getDataDirectPassageMap().then((response) => {
                removeMultiMarker();
                let data = response.data;
                if (data.length > 0) {
                    createMultiMarkerDirectPassage(data)
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
                    generateMapDirectPassage()
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
            let availableGuards = ['OP (PT. KAI)', 'JJ (PT. KAI)', 'Instansi Lain', 'Resmi Tidak Dijaga', 'Liar'];
            let availableSignEquipment = [
                'locomotive_flute',
                'crossing_gate',
                'non_crossing_gate',
                'warning',
                'critical_distance_450',
                'critical_distance_300',
                'critical_distance_100',
                'stop_sign',
                'walking_ban',
                'vehicle_entry_ban',
                'shock_line',
            ];

            try {
                let url = path + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let area = data['area']['name'];
                let track = data['track']['code'];
                let subTrack = data['sub_track']['code'];
                let name = data['name'];
                let stakes = data['stakes'];
                let width = data['width'];
                let road_construction = data['road_construction'];
                let road_name = data['road_name'];
                let road_class = data['road_name'];
                let elevation = data['elevation'];
                let guarded_by = data['guarded_by'];
                let technical_documentation = data['technical_documentation'];
                let city = data['city']['name'];
                let latitude = data['latitude'];
                let longitude = data['longitude'];
                let description = data['description'];
                let is_closed = data['is_closed'] === 1 ? 'Tidak Aktif' : 'Aktif';
                $('#area').val(area);
                $('#track').val(track);
                $('#sub_track').val(subTrack);
                $('#name').val(name);
                $('#stakes').val(stakes);
                $('#width').val(width);
                $('#road_construction').val(road_construction);
                $('#elevation').val(elevation);
                $('#road_class').val(road_class);
                $('#road_name').val(road_name);
                $('#guarded_by').val(availableGuards[guarded_by]);
                $('#technical_documentation').val(technical_documentation);
                $('#city').val(city);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                $('#is_closed').val(is_closed);
                $('#description').val(description);
                $.each(availableSignEquipment, function (k, v) {
                    let value = data['sign_equipment'][v] === 1 ? 'V' : '-';
                    let el = '#' + v;
                    $(el).html(value);
                });
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
                        d.area = $('#area-option').val();
                        // d.track = $('#track-option').val();
                        d.type = 'table';
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center',
                },
                    {
                        data: 'area.name',
                        name: 'area.name',
                        className: 'text-center',
                    },
                    {
                        data: 'track.code',
                        name: 'track.code',
                        className: 'text-center',
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center',
                    },
                    {
                        data: 'stakes',
                        name: 'stakes',
                        className: 'text-center',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center',
                    },
                    {
                        data: null,
                        name: null,
                        className: 'text-center',
                        render: function (data) {
                            let url = path + '/' + data['id'] + '/peristiwa-luar-biasa-hebat';
                            return '<a href="' + url + '" class="btn-guard me-2 btn-table-action" data-id="' +
                                data['id'] + '">' + data['count_accident'] + '</a>';
                        }
                    },
                    // {
                    //     data: null,
                    //     name: null,
                    //     className: 'text-center',
                    //     render: function (data) {
                    //         let url = path + '/' + data['id'] + '/penjaga-jalur-lintasan';
                    //         return '<a href="' + url + '" class="btn-guard me-2 btn-table-action" data-id="' +
                    //             data['id'] + '">' + data['count_guard'] + '</a>';
                    //     }
                    // },
                    {
                        data: null,
                        name: null,
                        className: 'text-center',
                        render: function (data) {
                            return data['is_closed'] === 1 ? 'Tidak Aktif' : 'Aktif'
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            let url = path + '/' + data['id'] + '/gambar';
                            return '<a href="' + url + '" class="btn-image btn-table-action">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' +
                                data['id'] + '">Detail</a>' +
                                '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data[
                                    'id'] +
                                '">Delete</a>';
                        },
                        orderable: false,
                        className: 'text-center',
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
                generateMapDirectPassage();
            });

            $('#btn-export').on('click', function (e) {
                e.preventDefault();
                let area = $('#area-option').val();
                let track = $('#track-option').val();
                let queryParam = '?area=' + area + '&track=' + track;
                let exportPath = path + '/excel' + queryParam;
                window.open(exportPath, '_blank');
            });
        })
    </script>
@endsection
