@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SERTIFIKASI SARANA LOKOMOTIF</h1>
            <p class="mb-0">Manajemen Data Sertifikasi Sarana Lokomotif</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sertifikasi Sarana Lokomotif</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm">
        <div class="title">
            <p>Sertifikasi Sarana Lokomotif</p>
            <a class="btn-utama sml rnd " href="{{ route('facility-certification-locomotive.create') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
            <div class="d-flex align-items-center mb-3">
                <div class="flex-grow-1">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active d-flex align-items-center" id="pills-table-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab"
                                    aria-controls="pills-table" aria-selected="true">
                                <i class="material-symbols-outlined me-1"
                                   style="font-size: 14px; color: inherit">view_list</i>
                                Data
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center" id="pills-table-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-table" type="button" role="tab" aria-controls="pills-table"
                                    aria-selected="true">
                                <i class="material-symbols-outlined me-1"
                                   style="font-size: 14px; color: inherit">demography</i>
                                Rekapitulasi
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-table" role="tabpanel"
                     aria-labelledby="pills-table-tab">
                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-4">--}}
                    {{--                            <div class="form-group w-100">--}}
                    {{--                                <label for="locomotive_type" class="form-label">Tipe Sarana</label>--}}
                    {{--                                <select class="select2 form-control" name="locomotive_type" id="locomotive_type"--}}
                    {{--                                    style="width: 100%;">--}}
                    {{--                                    <option value="" selected>Semua</option>--}}
                    {{--                                    @foreach ($locomotive_types as $locomotive_type)--}}
                    {{--                                        <option value="{{ $locomotive_type->id }}">{{ $locomotive_type->code }}</option>--}}
                    {{--                                    @endforeach--}}
                    {{--                                </select>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-4">--}}
                    {{--                            <div class="form-group w-100">--}}
                    {{--                                <label for="area" class="form-label">Wilayah</label>--}}
                    {{--                                <select class="select2 form-control" name="area" id="area" style="width: 100%;">--}}
                    {{--                                    <option value="" selected>Semua</option>--}}
                    {{--                                    @foreach ($areas as $area)--}}
                    {{--                                        <option value="{{ $area->id }}">{{ $area->name }}</option>--}}
                    {{--                                    @endforeach--}}
                    {{--                                </select>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-4">--}}
                    {{--                            <div class="form-group w-100">--}}
                    {{--                                <label for="storehouse" class="form-label">Depo Induk</label>--}}
                    {{--                                <select class="select2 form-control" name="storehouse" id="storehouse" style="width: 100%;">--}}
                    {{--                                    <option value="" selected>Semua</option>--}}
                    {{--                                </select>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <hr>--}}
                    <table id="table-data" class="display table table-striped w-100">
                        <thead>
                        <tr>
                            <th class="text-center middle-header" width="5%">#</th>
                            {{--                                <th class="text-center">Tipe Sarana</th>--}}
                            <th class="text-center middle-header" width="10%">Wilayah</th>
                            <th class="text-center middle-header" width="10%">Kepemilikan</th>
                            <th class="text-center middle-header" width="12%">No. Sarana</th>
                            {{--                                <th class="text-center">Tipe Depo</th>--}}
                            <th class="text-center middle-header" width="8%">Depo Induk</th>
                            {{--                                <th class="text-center">Mulai Dinas</th>--}}
                            <th class="text-center middle-header">No. BA Pengujian</th>
                            <th class="text-center middle-header" width="10%">Masa Berlaku Sarana</th>
                            <th class="text-center middle-header" width="5%">Akan Habis (Hari)</th>
                            {{--                                <th class="text-center">Status</th>--}}
                            <th class="text-center middle-header" width="15%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-detail-certification" tabindex="-1" aria-labelledby="modal-detail-certification"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('facility-certification-locomotive') }}';

        let areaPath = '{{ route('area') }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));


        function getStorehouseByAreaID() {
            let areaID = $('#area').val();
            let url = areaPath + '/' + areaID + '/storehouse';
            return $.get(url);
        }

        function generateStorehouseOption() {
            let elOption = $('#storehouse');
            elOption.empty();
            getStorehouseByAreaID().then((response) => {
                let data = response.data;
                elOption.append('<option value="" selected>Semua</option>');
                $.each(data, function (k, v) {
                    elOption.append('<option value="' + v['id'] + '">' + v['name'] + ' (' + v[
                        'storehouse_type']['name'] + ')</option>')
                });
                $('#storehouse').select2({
                    width: 'resolve',
                });
                console.log(response);
            }).catch((error) => {
                console.log(error)
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
                    url: path,
                    'data': function (d) {
                        d.type = 'table';
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
                    // {
                    //     data: 'locomotive_type.name',
                    //     name: 'locomotive_type.name',
                    //     width: '120px',
                    //     visible: false,
                    // },
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

                    // {
                    //     data: 'storehouse.storehouse_type.name',
                    //     name: 'storehouse.storehouse_type.name',
                    //     width: '120px',
                    //     visible: false,
                    // },
                    {
                        data: 'storehouse.name',
                        name: 'storehouse.name',
                        className: 'text-center',
                        // width: '120px',
                    },
                    // {
                    //     data: 'service_start_date',
                    //     name: 'service_start_date',
                    //     render: function(data) {
                    //         const v = new Date(data);
                    //         return v.toLocaleDateString('id-ID', {
                    //             month: '2-digit',
                    //             year: 'numeric',
                    //             day: '2-digit'
                    //         }).split('/').join('-')
                    //     },
                    //     width: '100px',
                    // },
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
                        // width: '140px',
                    },
                    {
                        data: 'expired_in',
                        name: 'expired_in',
                        render: function (data) {
                            return data + ' hari';
                        },
                        className: 'text-center',
                        // width: '80px',
                    },
                    // {
                    //     data: 'status',
                    //     name: 'status',
                    //     render: function(data) {
                    //         if (data === 'valid') {
                    //             return 'Berlaku';
                    //         }
                    //         return 'Habis Masa Berlaku';
                    //     },
                    //     width: '100px',
                    // },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="#" class="btn-detail me-2 btn-table-action">Detail</a>' +
                                '<a href="' + urlEdit + '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false,
                        width: '120px',
                        className: 'text-center',
                    }
                ],
                columnDefs: [
                    // {
                    //     targets: '_all',
                    //     className: 'text-center'
                    // }
                ],
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
                createdRow: function (row, data, index) {
                    if (data['expired_in'] < 5) {
                        $('td', row).css({'background-color': '#fecba1'});
                    }
                }
            });
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                modalDetail.show();
            });
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
                });
            });
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            generateStorehouseOption();
            $('#area').on('change', function (e) {
                generateStorehouseOption();
            });
            generateTableFacilityCertification();
        });
    </script>
@endsection
