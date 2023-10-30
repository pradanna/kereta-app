@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">BANGUNAN LIAR</h1>
            <p class="mb-0">Manajemen Data Bangunan Liar</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bangunan Liar</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Bangunan Liar</p>
            <div class="d-flex align-item-center">
                <a class="btn-utama sml rnd me-2" href="{{ route('illegal-building.add') }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
                <a class="btn-success sml rnd" href="{{ route('illegal-building.excel') }}" target="_blank">Export Excel
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_copy</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                    <tr>
                        <th class="text-center middle-header" width="5%" rowspan="2">#</th>
                        <th class="text-center middle-header" width="10%" rowspan="2">Perlintasan</th>
                        <th class="text-center middle-header" width="10%" rowspan="2">Antara</th>
                        <th class="text-center middle-header" rowspan="2">KM/HM</th>
                        <th class="text-center middle-header" width="12%" rowspan="2">Kecamatan</th>
                        <th class="text-center middle-header" colspan="2">Luas</th>
                        <th class="text-center middle-header" width="10%" rowspan="2">Jumlah Bangli</th>
                        <th class="text-center middle-header" width="15%" rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center middle-header" width="8%">Tanah (m2)</th>
                        <th class="text-center middle-header" width="8%">Bangunan (m2)</th>
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
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Bangunan Liar</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="track" class="form-label">Perlintasan</label>
                                <input type="text" class="form-control" id="track" name="track" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="sub_track" class="form-label">Lintas Antara</label>
                                <input type="text" class="form-control" id="sub_track" name="sub_track" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="city" class="form-label">Kota / Kabupaten</label>
                                <input type="text" class="form-control" id="city" name="city" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="district" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="district" name="district" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="stakes" class="form-label">KM/HM</label>
                                <input type="text" class="form-control" id="stakes" name="stakes" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="surface_area" class="form-label">Luas Tanah (m2)</label>
                                <input type="number" step="any" class="form-control" id="surface_area"
                                    name="surface_area" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="building_area" class="form-label">Luas Bangunan (m2)</label>
                                <input type="number" step="any" class="form-control" id="building_area"
                                    name="building_area" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="distance_from_rail" class="form-label">Jarak Dari AS Rel</label>
                                <input type="number" step="any" class="form-control" id="distance_from_rail"
                                    name="distance_from_rail" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="illegal_building" class="form-label">Jumlah Bangunan Liar</label>
                                <input type="number" step="any" class="form-control" id="illegal_building"
                                    name="illegal_building" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="demolished" class="form-label">Sudah Dibongkar</label>
                                <input type="number" step="any" class="form-control" id="demolished"
                                    name="demolished" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}" />
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('illegal-building') }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));

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

        function eventOpenDetail() {
            $('.btn-detail').on('click', function(e) {
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
                let subTrack = data['sub_track']['code'];
                let track = data['sub_track']['track']['code'];
                let district = data['district']['name'];
                let city = data['district']['city']['name'];
                let stakes = data['stakes'];
                let surfaceArea = data['surface_area'];
                let buildingArea = data['building_area'];
                let distanceFromRail = data['distance_from_rail'];
                let illegalBuilding = data['illegal_building'];
                let demolished = data['demolished'];
                $('#sub_track').val(subTrack);
                $('#track').val(track);
                $('#district').val(district);
                $('#city').val(city);
                $('#stakes').val(stakes);
                $('#surface_area').val(surfaceArea);
                $('#building_area').val(buildingArea);
                $('#distance_from_rail').val(distanceFromRail);
                $('#illegal_building').val(illegalBuilding);
                $('#demolished').val(demolished);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }

        $(document).ready(function() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: path,
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
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
                        data: 'stakes',
                        name: 'stakes',
                        className: 'text-center',
                    },
                    {
                        data: 'district.name',
                        name: 'district.name',
                        className: 'text-center',
                    },
                    {
                        data: 'surface_area',
                        name: 'surface_area',
                        className: 'text-center',
                    },
                    {
                        data: 'building_area',
                        name: 'building_area',
                        className: 'text-center',
                    },
                    {
                        data: 'illegal_building',
                        name: 'illegal_building',
                        className: 'text-center',
                    },
                    {
                        data: null,
                        render: function(data) {
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
                "fnDrawCallback": function(setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
            })
        })
    </script>
@endsection
