@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER DEPO DAN BALAI YASA</h1>
            <p class="mb-0">Manajemen Data Master Depo Dan Balai Yasa</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Depo Dan Balai Yasa</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="row flex-grow-1 gx-2">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label d-none">Daerah Operasi</label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                <option value="">Semua Daerah Operasi</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="storehouse_type" class="form-label d-none">Tipe Depo</label>
                            <select class="select2 form-control" name="storehouse_type" id="storehouse_type"
                                style="width: 100%;">
                                <option value="">Semua Tipe Depo</option>
                                @foreach ($storehouse_types as $storehouse_type)
                                    <option value="{{ $storehouse_type->id }}">{{ $storehouse_type->name }}</option>
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
    <div class="panel w-100 shadow-sm">
        <div class="title">
            <p>Data Depo dan Balai Yasa</p>
            <a class="btn-utama sml rnd" href="{{ route('storehouse.create') }}">Tambah
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
                            <button class="nav-link d-flex align-items-center" id="pills-map-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-map" type="button" role="tab" aria-controls="pills-map"
                                aria-selected="false">
                                <i class="material-symbols-outlined me-1" style="font-size: 14px; color: inherit">public</i>
                                Peta
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">

                    <table id="table-data" class="display table w-100">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="15%" class="text-center">Daerah Operasi</th>
                                <th width="15%" class="text-center">Kota</th>
                                <th width="15%">Tipe</th>
                                <th>Nama</th>
                                <th class="text-center middle-header" width="12%">Gambar</th>
                                <th width="12%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
                    <div id="main-map" style="width: 100%; height: calc(100vh - 70px); border-radius: 10px;"></div>
                    <hr>
                    <p class="fw-italic">Keterangan :</p>
                    <div class="row">
                        @foreach ($storehouse_types as $storehouse_type)
                            <div class="col-4 mb-1">
                                <div class="d-flex align-items-center w-100">
                                    <img class="me-2" src="{{ $storehouse_type->marker_icon }}" alt="img-marker">
                                    <p class="mb-0">{{ $storehouse_type->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/map-control.js') }}"></script>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('storehouse') }}';

        function changeTabEvent() {
            $("#pills-tab").on("shown.bs.tab", function(e) {
                if (e.target.id === "pills-table-tab") {
                    table.columns.adjust();
                }

                if (e.target.id === "pills-map-tab") {
                    generateMapStorehouse();
                }
            })
        }

        function getDataStorehouseMap() {
            let storehouseType = $('#storehouse_type').val();
            let area = $('#area').val();
            let url = path + '?type=map&storehouse_type=' + storehouseType + '&area=' + area;
            return $.get(url)
        }

        function generateMapStorehouse() {
            getDataStorehouseMap().then((response) => {
                removeMultiMarker();
                let data = response.data;
                if (data.length > 0) {
                    createMultiMarkerStorehouse(data)
                }
            }).catch((e) => {
                alert('terjadi kesalahan dalam pembuatan peta...');
                console.log(e)
            })
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
            let url = '{{ route('storehouse') }}' + '/' + id + '/delete';
            AjaxPost(url, {}, function() {
                SuccessAlert('Success', 'Berhasil Menghapus Data...').then(() => {
                    // generateMapStorehouse();
                    table.ajax.reload();
                });
            });
        }

        function generateTableStorehouse() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function(d) {
                        d.type = 'table';
                        d.storehouse_type = $('#storehouse_type').val();
                        d.area = $('#area').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'area.name',
                        name: 'area.name'
                    },
                    {
                        data: 'city.name',
                        name: 'city.name'
                    },
                    {
                        data: 'storehouse_type.name',
                        name: 'storehouse_type.name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function(data) {
                            let url = path + '/' + data['id'] + '/gambar';
                            return '<a href="' + url + '" class="btn-image btn-table-action">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>'
                        },
                        orderable: false
                    }
                ],
                columnDefs: [{
                    targets: [0, 1, 2, 4, 5],
                    className: 'text-center'
                }, {
                    targets: '_all',
                    className: 'middle-header'
                }],
                paging: true,
                "fnDrawCallback": function(setting) {
                    deleteEvent();
                },
                dom: 'ltrip'
            })
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            changeTabEvent();
            generateTableStorehouse();
            $('#btn-search').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload();
                generateMapStorehouse();
            });
        })
    </script>
@endsection
