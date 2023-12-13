@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">DAERAH RAWAN BENCANA <span class="capitalize">{{ $data->name }}</span></h1>
            <p class="mb-0">Data Daerah Rawan Bencana {{ $data->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('service-unit') }}">Satuan Pelayanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daerah Rawan Bencana {{ $data->name }}</li>
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
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#"
                        style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Daerah Rawan Bencana</p>
            <div class="d-flex align-item-center">
                <a class="btn-success sml rnd" href="#" id="btn-export" target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th width="15%" class="text-center">Satuan Pelayanan</th>
                        <th width="10%" class="text-center">Lokasi</th>
                        <th width="15%" class="text-center">Resort</th>
                        <th width="10%" class="text-center">Petak</th>
                        <th class="text-center">Jenis Rawan</th>
                        <th width="5%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-detail-certification" tabindex="-1" aria-labelledby="modal-detail-certification"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Daerah Rawan Bencana</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="service_unit" class="form-label">Satuan Pelayanan</label>
                                <input type="text" class="form-control" name="service_unit" id="service_unit" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="resort" class="form-label">Resort</label>
                                <input type="text" class="form-control" name="resort" id="resort" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="sub_track" class="form-label">Petak</label>
                                <input type="text" class="form-control" name="sub_track" id="sub_track" disabled>
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
                                <label for="block" class="form-label">KM</label>
                                <input type="text" step="any" class="form-control" id="block" name="block"
                                    placeholder="KM" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="lane" class="form-label">Jalur</label>
                                <input type="text" step="any" class="form-control" id="lane" name="lane"
                                    placeholder="Jalur" disabled>
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
                            <div class="w-100">
                                <label for="handling" class="form-label">Penanganan</label>
                                <textarea rows="3" class="form-control" id="handling" name="handling" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" id="description" name="description" disabled></textarea>
                            </div>
                        </div>
                    </div>
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
        let serviceUnitID = '{{ $data->id }}';
        let disasterAreaPath = '{{ route('disaster-area') }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

        function eventOpenDetail() {
            $('.btn-detail').on('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                detailHandler(id);
            });
        }

        async function detailHandler(id) {
            try {
                let url = disasterAreaPath + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let serviceUnit = data['resort']['service_unit']['name'];
                let resort = data['resort']['name'];
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
                $('#service_unit').val(serviceUnit);
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

        $(document).ready(function() {
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
                    url: disasterAreaPath,
                    'data': function(d) {
                        d.service_unit = serviceUnitID;
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
                        data: 'resort.service_unit.name',
                        name: 'resort.service_unit.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'location_type',
                        name: 'location_type',
                        className: 'text-center middle-header',
                        render: function(data) {
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
                        data: 'resort.name',
                        name: 'resort.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'disaster_type.name',
                        name: 'disaster_type.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: null,
                        render: function(data) {
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' +
                                data['id'] + '">Detail</a>';
                        },
                        orderable: false,
                        className: 'text-center middle-header',
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
                let resort = $('#resort-option').val();
                let locationType = $('#location-type-option').val();
                let queryParam = '?service_unit=' + serviceUnitID + '&resort=' + resort +
                    '&location_type=' + locationType;
                let exportPath = '{{ route('disaster-area.excel') }}' + queryParam;
                window.open(exportPath, '_blank');
            });
        });
    </script>
@endsection
