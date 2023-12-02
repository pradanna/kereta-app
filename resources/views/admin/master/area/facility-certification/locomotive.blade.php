@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SERTIFIKASI SARANA LOKOMOTIF <span class="capitalize">{{ $data->name }}</span></h1>
            <p class="mb-0">Data Sertifikasi Sarana Lokomotif {{ $data->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('area') }}">Daerah Operasi</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('area.facility-certification', ['id' => $data->id]) }}">{{ $data->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Lokomotif</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
{{--                    <div class="col-3">--}}
{{--                        <div class="form-group w-100">--}}
{{--                            <label for="area-option" class="form-label d-none">Daerah Operasi</label>--}}
{{--                            <select class="select2 form-control" name="area-option" id="area-option"--}}
{{--                                    style="width: 100%;">--}}
{{--                                <option value="">Semua Daerah Operasi</option>--}}
{{--                                @foreach ($areas as $area)--}}
{{--                                    <option value="{{ $area->id }}">{{ $area->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="storehouse-option" class="form-label d-none">Depo</label>
                            <select class="select2 form-control" name="storehouse-option" id="storehouse-option"
                                    style="width: 100%;">
                                <option value="">Semua Depo</option>
                                @foreach ($storehouses as $storehouse)
                                    <option value="{{ $storehouse->id }}">{{ $storehouse->name }} ({{ $storehouse->storehouse_type->name }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="status-option" class="form-label d-none">Status</label>
                            <select class="select2 form-control" name="status-option" id="status-option"
                                    style="width: 100%;">
                                <option value="">Semua Status</option>
                                <option value="1">Berlaku</option>
                                <option value="0">Habis Masa Berlaku</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none"></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Cari No. Sarana atau No. BA Pengujian">
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#" style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel w-100 shadow-sm">
        <div class="title">
            <p>Data Sertifikasi Sarana Lokomotif</p>
            <div class="d-flex align-item-center">
                <a class="btn-success sml rnd" href="#" id="btn-export"
                   target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="text-center middle-header" width="10%">Wilayah</th>
                    <th class="text-center middle-header" width="10%">Kepemilikan</th>
                    <th class="text-center middle-header" width="12%">No. Sarana</th>
                    <th class="text-center middle-header" width="12%">Depo Induk</th>
                    <th class="text-center middle-header">No. BA Pengujian</th>
                    <th class="text-center middle-header" width="10%">Masa Berlaku</th>
                    <th class="text-center middle-header" width="10%">Akan Habis (Hari)</th>
                    <th class="text-center middle-header" width="5%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modal-detail-certification" tabindex="-1" aria-labelledby="modal-detail-certification"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Sarana Lokomotif</p>
                    <hr>
                    <div class="row mb-3">

                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="area" class="form-label">Wilayah</label>
                                <input type="text" class="form-control" id="area" name="area" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="storehouse" class="form-label">Depo Induk</label>
                                <input type="text" class="form-control" id="storehouse" name="storehouse" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="locomotive_type" class="form-label">Jenis Sarana</label>
                                <input type="text" class="form-control" id="locomotive_type" name="locomotive_type"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="ownership" class="form-label">Kepemilikan</label>
                                <input type="text" class="form-control" id="ownership" name="ownership" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="facility_number" class="form-label">No. Sarana</label>
                                <input type="text" class="form-control" id="facility_number" name="facility_number"
                                       disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="testing_number" class="form-label">No. BA Pengujian</label>
                                <input type="text" class="form-control" id="testing_number" name="testing_number"
                                       disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="service_start_date" class="form-label">Mulai Dinas</label>
                                <input type="text" class="form-control" id="service_start_date"
                                       name="service_start_date" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="service_expired_date" class="form-label">Masa Berlaku</label>
                                <input type="text" class="form-control" id="service_expired_date"
                                       name="service_expired_date" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="expired_in" class="form-label">Akan Habis (Hari)</label>
                                <input type="text" class="form-control" id="expired_in" name="expired_in" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" disabled>
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
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let areaID = '{{ $data->id }}';
        let areaPath = '{{ route('area') }}';
        let facilityPath = '{{ route('facility-certification-locomotive') }}';
        let expiration = parseInt('{{ \App\Helper\Formula::ExpirationLimit }}');

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

        function getDataStorehouse() {
            let areaID = $('#area-option').val();
            let serviceUnitID = '{{ $data->id }}';
            let storehousePath = '{{ route('storehouse') }}';
            let url = storehousePath + '/area?area=' + areaID + '&service_unit=' + serviceUnitID;
            return $.get(url)
        }

        function generateStorehouseOption() {
            let el = $('#storehouse-option');
            el.empty();
            let elOption = '<option value="">Semua Depo</option>';
            getDataStorehouse().then((response) => {
                const data = response['data'];
                $.each(data, function (k, v) {
                    elOption += '<option value="' + v['id'] + '">' + v['name'] + ' (' + v['storehouse_type']['name'] + ')</option>';
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

        function generateTableFacilityCertification() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: facilityPath,
                    'data': function (d) {
                        d.area = areaID;
                        d.name = $('#name').val();
                        d.storehouse = $('#storehouse-option').val();
                        d.status = $('#status-option').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center'
                    // width: '30px'
                },
                    {
                        data: 'area.name',
                        name: 'area.name',
                        className: 'text-center'
                        // width: '150px',
                    },
                    {
                        data: 'ownership',
                        name: 'ownership',
                        className: 'text-center'
                        // width: '120px'
                    },
                    {
                        data: 'facility_number',
                        name: 'facility_number',
                        className: 'text-center'
                        // width: '100px'
                    },
                    {
                        data: 'storehouse',
                        name: 'storehouse',
                        className: 'text-center',
                        render: function (data) {
                            return data['name'] + ' ('+data['storehouse_type']['name']+')'
                        }
                        // width: '120px',
                    },
                    {
                        data: 'testing_number',
                        name: 'testing_number',
                        className: 'text-center',
                        // width: '150px',
                    },
                    {
                        data: 'service_expired_date',
                        name: 'service_expired_date',
                        render: function (data) {
                            const v = new Date(data);
                            return v.toLocaleDateString('id-ID', {
                                month: '2-digit',
                                year: 'numeric',
                                day: '2-digit'
                            }).split('/').join('-')
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'expired_in',
                        name: 'expired_in',
                        render: function (data) {
                            return data;
                        },
                        className: 'text-center',
                        // width: '80px',
                    },
                    {
                        data: null,
                        render: function (data) {
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data['id'] + '">Detail</a>';
                        },
                        orderable: false,
                        className: 'text-center',
                    }
                ],
                columnDefs: [
                    {
                        targets: '_all',
                        className: 'middle-header'
                    }
                ],
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventOpenDetail();
                },
                createdRow: function (row, data, index) {
                    if (data['expired_in'] < expiration) {
                        $('td', row).css({
                            'background-color': '#fecba1'
                        });
                    }
                },
                dom: 'ltrip'
            });
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                detailHandler(id)
            });
        }

        async function detailHandler(id) {
            try {
                let url = facilityPath + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let locomotiveType = data['locomotive_type']['name'];
                let area = data['area']['name'];
                let storehouse = data['storehouse']['name'];
                let storehouseType = data['storehouse']['storehouse_type']['name'];
                let ownership = data['ownership'];
                let facilityNumber = data['facility_number'];
                let testingNumber = data['testing_number'];
                let serviceStartDate = data['service_start_date'];
                let serviceExpiredDate = data['service_expired_date'];
                let expiredIn = data['expired_in'];
                let status = data['status'] === 'valid' ? 'BERLAKU' : 'HABIS MASA BERLAKU';
                $('#locomotive_type').val(locomotiveType);
                $('#area').val(area);
                $('#storehouse').val(storehouse + ' (' + storehouseType + ')');
                $('#ownership').val(ownership);
                $('#facility_number').val(facilityNumber);
                $('#testing_number').val(testingNumber);
                $('#service_start_date').val(serviceStartDate);
                $('#service_expired_date').val(serviceExpiredDate);
                $('#status').val(status);
                $('#expired_in').val(expiredIn);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            // generateStorehouseOption();
            // $('#area-option').on('change', function () {
            //     generateStorehouseOption();
            // });
            generateTableFacilityCertification();
            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });
            $('#btn-export').on('click', function (e) {
                e.preventDefault();
                let area = areaID;
                let name = $('#name').val();
                let storehouse = $('#storehouse-option').val();
                let status = $('#status-option').val();
                let queryParam = '?area=' + area + '&name=' + name + '&storehouse=' + storehouse + '&status=' + status;
                let exportPath = '{{ route('facility-certification-locomotive.excel') }}' + queryParam;
                window.open(exportPath, '_blank');
            });
        });
    </script>
@endsection
