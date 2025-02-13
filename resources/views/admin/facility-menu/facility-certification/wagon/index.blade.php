@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SERTIFIKASI SARANA GERBONG</h1>
            <p class="mb-0">Manajemen Data Sertifikasi Sarana GERBONG</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.facility-certification') }}">Sertifikasi Sarana</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Gerbong</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="area-option" class="form-label d-none">Daerah Operasi</label>
                            <select class="select2 form-control" name="area-option" id="area-option" style="width: 100%;">
                                <option value="">Semua Daerah Operasi</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{--                    <div class="col-3"> --}}
                    {{--                        <div class="form-group w-100"> --}}
                    {{--                            <label for="storehouse-option" class="form-label d-none">Depo</label> --}}
                    {{--                            <select class="select2 form-control" name="storehouse-option" id="storehouse-option" --}}
                    {{--                                    style="width: 100%;"> --}}
                    {{--                                <option value="">Semua Depo</option> --}}
                    {{--                            </select> --}}
                    {{--                        </div> --}}
                    {{--                    </div> --}}
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="status-option" class="form-label d-none">Status</label>
                            <select class="select2 form-control" name="status-option" id="status-option"
                                style="width: 100%;">
                                <option value="">Semua Status</option>
                                <option value="2">Berlaku</option>
                                <option value="1">Akan Habis Masa Berlaku</option>
                                <option value="0">Habis Masa Berlaku</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none"></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Cari No. Sarana atau No. BA Pengujian">
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
    <div class="panel w-100 shadow-sm">
        <div class="title">
            <p>Sertifikasi Sarana Gerbong</p>
            <div class="d-flex align-item-center">
                @if ($access['is_granted_create'])
                    <a class="btn-utama sml rnd me-2" href="{{ route('means.facility-certification.wagon.create') }}">Tambah
                        <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                    </a>
                @endif
                <a class="btn-success sml rnd" href="#" id="btn-export" target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table w-100">
                <thead>
                    <tr>
                        <th class="text-center middle-header" width="5%">#</th>
                        {{--                            <th class="text-center">Tipe Sarana</th> --}}
                        <th class="text-center middle-header" width="10%">Wilayah</th>
                        <th class="text-center middle-header" width="10%">Kepemilikan</th>
                        <th class="text-center middle-header" width="12%">No. Sarana</th>
                        {{--                            <th class="text-center middle-header" width="5%">Tipe Depo</th> --}}
                        <th class="text-center middle-header" width="8%">Depo Induk</th>
                        {{--                            <th class="text-center middle-header" width="5%">Mulai Dinas</th> --}}
                        <th class="text-center middle-header">No. BA Pengujian</th>
                        <th class="text-center middle-header" width="10%">Masa Berlaku</th>
                        <th class="text-center middle-header" width="5%">Akan Habis (Hari)</th>
                        {{--                            <th class="text-center middle-header" width="5%">Status</th> --}}
                        <th class="text-center middle-header" width="15%">Aksi</th>
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
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Sarana Gerbong</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="area" class="form-label">Wilayah</label>
                                <input type="text" class="form-control" id="area" name="area" disabled>
                            </div>
                        </div>
                        {{--                        <div class="col-6"> --}}
                        {{--                            <div class="form-group w-100"> --}}
                        {{--                                <label for="wagon_sub_type" class="form-label">Jenis Gerbong</label> --}}
                        {{--                                <input type="text" class="form-control" id="wagon_sub_type" name="wagon_sub_type" --}}
                        {{--                                    disabled> --}}
                        {{--                            </div> --}}
                        {{--                        </div> --}}
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="storehouse" class="form-label">Depo Induk</label>
                                <input type="text" class="form-control" id="storehouse" name="storehouse" disabled>
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
                                    name="service_start_date" placeholder="dd-mm-yyyy" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="service_expired_date" class="form-label">Masa Berlaku</label>
                                <input type="text" class="form-control" id="service_expired_date"
                                    name="service_expired_date" placeholder="dd-mm-yyyy" disabled>
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
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="description" name="description"
                                    placeholder="Keterangan" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';
        let expiration = parseInt('{{ \App\Helper\Formula::ExpirationLimit }}');
        let grantedUpdate = '{{ $access['is_granted_update'] }}';
        let grantedDelete = '{{ $access['is_granted_delete'] }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

        function generateTableFacilityCertification() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function(d) {
                        d.area = $('#area-option').val();
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
                    },
                    // {data: 'train_type.name', name: 'train_type.name', width: '120px', visible: false,},
                    {
                        data: 'area.name',
                        name: 'area.name',
                        className: 'text-center'
                    },
                    {
                        data: 'ownership',
                        name: 'ownership',
                        className: 'text-center'
                    },
                    {
                        data: 'facility_number',
                        name: 'facility_number',
                        className: 'text-center'
                    },
                    // {data: 'storehouse.storehouse_type.name', name: 'storehouse.storehouse_type.name', width: '120px', visible: false,},
                    {
                        data: 'storehouse',
                        name: 'storehouse',
                        className: 'text-center',
                        render: function(data) {
                            return data['name'] + ' (' + data['storehouse_type']['name'] + ')'
                        }
                        // width: '120px',
                    },
                    {
                        data: 'testing_number',
                        name: 'testing_number',
                        className: 'text-center',
                        render: function(data) {
                            return data === null ? '-' : data;
                        }
                    },
                    {
                        data: 'service_expired_date',
                        name: 'service_expired_date',
                        render: function(data) {
                            const v = new Date(data);
                            return v.toLocaleDateString('id-ID', {
                                month: '2-digit',
                                year: 'numeric',
                                day: '2-digit'
                            }).split('/').join('-')
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'expired_in',
                        name: 'expired_in',
                        render: function(data) {
                            return data;
                        },
                        // width: '80px',
                        className: 'text-center'
                    },
                    {
                        data: null,
                        render: function(data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            let elEdit = grantedUpdate === '1' ? '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' : '';
                            let elDelete = grantedDelete === '1' ?
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>' : '';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data[
                                'id'] + '">Detail</a>' + elEdit + elDelete;
                        },
                        orderable: false,
                        // width: '120px',
                        className: 'text-center'
                    }
                ],
                columnDefs: [{
                    targets: '_all',
                    className: 'middle-header'
                }],
                paging: true,
                "fnDrawCallback": function(setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
                createdRow: function(row, data, index) {
                    // if (data['expired_in'] < expiration) {
                    //     $('td', row).css({
                    //         'background-color': '#fecba1'
                    //     });
                    // }
                    if (data['expired_in'] < 0) {
                        $('td', row).css({
                            'background-color': '#fecba1'
                        });
                    }

                    if (data['expired_in'] > 1 && data['expired_in'] < 31) {
                        $('td', row).css({
                            'background-color': '#ece75f'
                        });
                    }
                },
                dom: 'ltrip'
            });
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                detailHandler(id)
            });
        }

        async function detailHandler(id) {
            try {
                let url = path + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                // let wagonSubType = data['wagon_sub_type']['name'];
                let area = data['area']['name'];
                let storehouse = data['storehouse']['name'];
                let storehouseType = data['storehouse']['storehouse_type']['name'];
                let ownership = data['ownership'];
                let facilityNumber = data['facility_number'];
                let testingNumber = data['testing_number'];
                let serviceStartDate = data['service_start_date'];
                let serviceExpiredDate = data['service_expired_date'];
                let expiredIn = data['expired_in'];
                let description = data['description'];
                // let status = data['status'] === 'valid' ? 'BERLAKU' : 'HABIS MASA BERLAKU';
                let status = 'BERLAKU';

                if (data['expired_in'] < 0) {
                    status = 'HABIS MASA BERLAKU';
                }

                if (data['expired_in'] > 1 && data['expired_in'] < 31) {
                    status = 'AKAN HABIS MASA BERLAKU'
                }

                const tmpDate = new Date(serviceStartDate);
                let serviceStartDateValue = tmpDate.getFullYear();
                // $('#wagon_sub_type').val(wagonSubType);
                $('#area').val(area);
                $('#storehouse').val(storehouse + ' (' + storehouseType + ')');
                $('#ownership').val(ownership);
                $('#facility_number').val(facilityNumber);
                $('#testing_number').val(testingNumber);
                $('#service_start_date').val(serviceStartDateValue);
                $('#service_expired_date').val(serviceExpiredDate);
                $('#status').val(status);
                $('#expired_in').val(expiredIn);
                $('#description').val(description);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }

        function deleteEvent() {
            $('.btn-delete').on('click', function(e) {
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
            AjaxPost(url, {}, function() {
                SuccessAlert('Success', 'Berhasil Menghapus Data...').then(() => {
                    table.ajax.reload();
                });
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });

            generateTableFacilityCertification();
            $('#btn-search').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-export').on('click', function(e) {
                e.preventDefault();
                let area = $('#area-option').val();
                let name = $('#name').val();
                let status = $('#status-option').val();
                let queryParam = '?area=' + area + '&name=' + name + '&status=' + status;
                let exportPath = '{{ route('means.facility-certification.wagon.excel') }}' + queryParam;
                window.open(exportPath, '_blank');
            });
        });
    </script>
@endsection
