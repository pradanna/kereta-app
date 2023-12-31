@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER DAERAH OPERASI</h1>
            <p class="mb-0">Manajemen Data Master Daerah Operasi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daerah Operasi</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Daerah Operasi</p>
            <a class="btn-utama sml rnd " href="{{ route('area.create') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
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
                <div class="tab-pane fade show active" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                    <table id="table-data" class="display table w-100">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="15%">Satuan Pelayanan</th>
                            <th>Nama Daerah Operasi</th>
                            <th width="12%" class="text-center">Aksi</th>
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
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
    <script src="{{ asset('js/map-control.js') }}"></script>
@endsection

@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('area') }}';

        function changeTabEvent() {
            $("#pills-tab").on("shown.bs.tab", function (e) {
                if (e.target.id === "pills-table-tab") {
                    table.columns.adjust();
                }
                if (e.target.id === "pills-map-tab") {
                    generateMapArea();
                }
            })
        }

        function getDataAreaMap() {
            let url = path + '?type=map';
            return $.get(url)
        }

        function generateMapArea() {
            getDataAreaMap().then((response) => {
                removeMultiMarker();
                let data = response.data;
                if (data.length > 0) {
                    createMultiMarkerArea(data)
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
                    generateMapArea();
                });
            });
        }

        function generateTableArea() {
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
                        d.type = 'table';
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                    {
                        data: 'service_unit.name',
                        name: 'service_unit.name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="' + urlEdit + '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] + '">Delete</a>'
                        },
                        orderable: false
                    }
                ],
                columnDefs: [{
                    targets: [0, 1, 3],
                    className: 'text-center'
                }],
                paging: true,
                "fnDrawCallback": function (setting) {
                    deleteEvent();
                }
            })
        }

        $(document).ready(function () {
            changeTabEvent();

            generateTableArea();
        })
    </script>
@endsection
