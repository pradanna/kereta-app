@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Depo Dan Balai Yasa</li>
            </ol>
        </nav>
    </div>
    <div class="card w-100 shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="flex-grow-1">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active d-flex align-items-center" id="pills-map-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-map"
                                    type="button" role="tab" aria-controls="pills-map" aria-selected="false">
                                <span class="material-icons-round me-1" style="font-size: 14px;">public</span>
                                Tampilan Peta
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center" id="pills-table-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-table" type="button" role="tab" aria-controls="pills-table"
                                    aria-selected="true">
                                <span class="material-icons-round me-1" style="font-size: 14px;">view_list</span>
                                Tampilan Grid
                            </button>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('storehouse.create') }}"
                   class="btn btn-primary d-flex align-items-center justify-content-center">
                    <span class="material-icons-round me-1" style="font-size: 14px;">add</span>
                    Tambah
                </a>
            </div>
            <hr>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
                    <div id="main-map" style="width: 100%; height: calc(100vh - 70px)"></div>
                </div>
                <div class="tab-pane fade" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                    <table id="table-data" class="display table table-striped w-100">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="15%" class="text-center">Daerah Operasi</th>
                            <th width="15%" class="text-center">Kota</th>
                            <th width="15%" class="text-center">Tipe</th>
                            <th>Nama</th>
                            <th width="12%" class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <script src="{{ asset('js/map-control.js') }}"></script>
@endsection

@section('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&callback=initMap&v=weekly"
        async></script>
    <script>
        let table;
        let path = '{{ route('storehouse') }}';

        function changeTabEvent() {
            $("#pills-tab").on("shown.bs.tab", function (e) {
                if (e.target.id === "pills-table-tab") {
                    table.columns.adjust();
                }
            })
        }

        function getDataStorehouseMap() {
            let url = path + '?type=map';
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
                console.log(e)
            })
        }

        function generateTableStorehouse() {
            table = $('#table-data').DataTable({
                scrollX: true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.type = 'table';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'area.name', name: 'area.name'},
                    {data: 'city.name', name: 'city.name'},
                    {data: 'storehouse_type.name', name: 'storehouse_type.name'},
                    {data: 'name', name: 'name'},
                    {
                        data: null, render: function (data) {
                            return '<a href="#" class="btn-edit me-1" data-id="' + data['id'] + '">Edit</a>' +
                                '<a href="#" class="btn-delete" data-id="' + data['id'] + '">Delete</a>'
                        }, orderable: false
                    }
                ],
                columnDefs: [
                    {
                        targets: [0, 1, 2, 3, 5],
                        className: 'text-center'
                    }
                ],
                paging: true,
            })
        }
        $(document).ready(function () {
            changeTabEvent();
            generateMapStorehouse();
            generateTableStorehouse();
        })
    </script>
@endsection
