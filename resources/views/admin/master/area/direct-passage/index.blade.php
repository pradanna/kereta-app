@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">JALUR PERLINTASAN LANGSUNG (JPL) <span class="capitalize">{{ $data->name }}</span></h1>
            <p class="mb-0">Rekapitulasi Data Jalur Perlintasan Langsung {{ $data->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('area') }}">Daerah Operasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">JPL {{ $data->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel" style="margin-bottom: 20px;">
        <div class="title">
            <p>Rekapitulasi Jalur Perlintasan Langsung (JPL)</p>
        </div>
        <div class="isi">
            <table id="table-summary" class="display table table-striped w-100">
                <thead>
                    <tr>
                        <th class="middle-header">Wilayah</th>
                        <th class="text-center middle-header" width="8%">OP (PT.KAI)</th>
                        <th class="text-center middle-header" width="8%">JJ (PT.KAI)</th>
                        <th class="text-center middle-header" width="8%">Instansi Lain</th>
                        <th class="text-center middle-header" width="8%">Resmi Tidak Dijaga</th>
                        <th class="text-center middle-header" width="8%">Liar</th>
                        <th class="text-center middle-header" width="8%">Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th class="middle-header">Jumlah</th>
                        <th class="text-center middle-header" width="8%">0</th>
                        <th class="text-center middle-header" width="8%">0</th>
                        <th class="text-center middle-header" width="8%">0</th>
                        <th class="text-center middle-header" width="8%">0</th>
                        <th class="text-center middle-header" width="8%">0</th>
                        <th class="text-center middle-header" width="8%">0</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    {{--                    <div class="col-6"> --}}
                    {{--                        <div class="form-group w-100"> --}}
                    {{--                            <label for="area-option" class="form-label d-none">Daerah Operasi</label> --}}
                    {{--                            <select class="select2 form-control" name="area-option" id="area-option" --}}
                    {{--                                    style="width: 100%;"> --}}
                    {{--                                <option value="">Semua Daerah Operasi</option> --}}
                    {{--                                @foreach ($areas as $area) --}}
                    {{--                                    <option value="{{ $area->id }}">{{ $area->name }}</option> --}}
                    {{--                                @endforeach --}}
                    {{--                            </select> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="track-option" class="form-label d-none">Perlintasan</label>
                            <select class="select2 form-control" name="track-option" id="track-option" style="width: 100%;">
                                <option value="">Semua Perlintasan</option>
                                @foreach ($tracks as $track)
                                    <option value="{{ $track->id }}">{{ $track->code }} ({{ $track->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#"
                        style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="title">
            <p>Data Jalur Perlintasan Langsung (JPL)</p>
            <div class="d-flex align-item-center">
                <a class="btn-success sml rnd" href="#" id="btn-export">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                    <tr>
                        <th class="text-center middle-header" width="5%">#</th>
                        <th class="text-center middle-header" width="10%">Wilayah</th>
                        <th class="text-center middle-header" width="10%">Perlintasan</th>
                        <th class="text-center middle-header" width="10%">Petak</th>
                        <th class="text-center middle-header" width="7%">JPL</th>
                        <th class="text-center middle-header" width="8%">KM/HM</th>
                        <th class="text-center middle-header" width="10%">Lebar Jalan</th>
                        <th class="middle-header">Nama Jalan</th>
                        <th class="text-center middle-header" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="track" class="form-label">Perlintasan</label>
                                <input type="text" class="form-control" id="track" name="track"
                                    placeholder="JPL" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="sub_track" class="form-label">Petak</label>
                                <input type="text" class="form-control" id="sub_track" name="sub_track"
                                    placeholder="JPL" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="name" class="form-label">JPL</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="JPL" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="stakes" class="form-label">KM/HM</label>
                                <input type="text" class="form-control" id="stakes" name="stakes"
                                    placeholder="KM/HM" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="accident_history" class="form-label">Riwayat Kecelakaan</label>
                                <input type="number" class="form-control" id="accident_history" name="accident_history"
                                    placeholder="0" disabled>
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
                        <div class="col-6">
                            <div class="w-100">
                                <label for="road_name" class="form-label">Nama Jalan / Daerah</label>
                                <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="road_name" name="road_name"
                                    placeholder="Konstruksi Jalan" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="description" name="description"
                                    placeholder="Keterangan" disabled></textarea>
                            </div>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let areaID = '{{ $data->id }}';
        let directPassagePath = '{{ route('direct-passage') }}';
        let summaryDirectPassagePath = '{{ route('summary-direct-passage') }}';
        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

        function getDataTrack() {
            let areaID = $('#area-option').val();
            let trackPath = '{{ route('track') }}';
            let url = trackPath + '/area?area=' + areaID;
            return $.get(url)
        }

        function generateDataTrackOption() {
            let el = $('#track-option');
            el.empty();
            let elOption = '<option value="">Semua Perlintasan</option>';
            getDataTrack().then((response) => {
                const data = response['data'];
                $.each(data, function(k, v) {
                    elOption += '<option value="' + v['id'] + '">' + v['code'] + '</option>';
                });
            }).catch((e) => {
                alert('terjadi kesalahan server...')
            }).always(() => {
                el.append(elOption);
                $('.select2').select2({
                    width: 'resolve',
                });
            })
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function(e) {
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
                let url = directPassagePath + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let track = data['sub_track']['track']['code'];
                let subTrack = data['sub_track']['code'];
                let name = data['name'];
                let stakes = data['stakes'];
                let width = data['width'];
                let road_construction = data['road_construction'];
                let road_name = data['road_name'];
                let guarded_by = data['guarded_by'];
                let technical_documentation = data['technical_documentation'];
                let city = data['city']['name'];
                let latitude = data['latitude'];
                let longitude = data['longitude'];
                let accident_history = data['accident_history'];
                let description = data['description'];
                $('#track').val(track);
                $('#sub_track').val(subTrack);
                $('#name').val(name);
                $('#stakes').val(stakes);
                $('#width').val(width);
                $('#road_construction').val(road_construction);
                $('#road_name').val(road_name);
                $('#guarded_by').val(availableGuards[guarded_by]);
                $('#technical_documentation').val(technical_documentation);
                $('#city').val(city);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                $('#accident_history').val(accident_history);
                $('#description').val(description);
                $.each(availableSignEquipment, function(k, v) {
                    let value = data['sign_equipment'][v] === 1 ? 'V' : '-';
                    let el = '#' + v;
                    $(el).html(value);
                });
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }

        function generateSummary() {
            $('#table-summary').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: summaryDirectPassagePath,
                    'data': function(d) {
                        d.area = areaID;
                    }
                },
                columns: [{
                        data: 'area',
                        name: 'area',
                    },
                    {
                        data: 'operator',
                        name: 'operator',
                        className: 'text-center'
                    },
                    {
                        data: 'unit_track',
                        name: 'unit_track',
                        className: 'text-center'
                    },
                    {
                        data: 'institution',
                        name: 'institution',
                        className: 'text-center'
                    },
                    {
                        data: 'unguarded',
                        name: 'unguarded',
                        className: 'text-center'
                    },
                    {
                        data: 'illegal',
                        name: 'illegal',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: 'text-center fw-bold'
                    },
                ],
                columnDefs: [{
                    target: '_all',
                    orderable: false
                }],
                dom: 't',
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();

                    let intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i :
                            0;
                    };
                    for (let i = 1; i < 7; i++) {
                        total = api
                            .column(i)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                        api.column(i).footer().innerHTML = total;
                    }

                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            // generateDataTrackOption();
            // $('#area-option').on('change', function () {
            //     generateDataTrackOption();
            // });
            generateSummary();
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: directPassagePath,
                    'data': function(d) {
                        d.area = areaID;
                        d.track = $('#track-option').val();
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
                        data: 'sub_track.track.area.name',
                        name: 'sub_track.track.area.name',
                        className: 'text-center',
                    },
                    {
                        data: 'sub_track.track.code',
                        name: 'sub_track.track.code',
                        className: 'text-center',
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center',
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'text-center',
                    },
                    {
                        data: 'stakes',
                        name: 'stakes',
                        className: 'text-center',
                    },
                    {
                        data: 'width',
                        name: 'width',
                        className: 'text-center',
                    },
                    {
                        data: 'road_name',
                        name: 'road_name',

                    },
                    {
                        data: null,
                        render: function(data) {
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' +
                                data['id'] + '">Detail</a>';
                        },
                        orderable: false,
                        className: 'text-center',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function(setting) {
                    eventOpenDetail();
                },
                dom: 'ltrip'
            });


            $('#btn-search').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-export').on('click', function(e) {
                e.preventDefault();
                let area = $('#area-option').val();
                let track = $('#track-option').val();
                let queryParam = '?area=' + area + '&track=' + track;
                let exportPath = '{{ route('direct-passage.excel') }}' + queryParam;
                window.open(exportPath, '_blank');
            });
        });
    </script>
@endsection
