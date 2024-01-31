@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">STASIUN KERETA API {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Stasiun Kereta Api {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('traffic') }}">Lalu Lintas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Stasiun Kereta Api {{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="row flex-grow-1 gx-2">
                    <div class="col-3">
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
                    <div class="col-9">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none"></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Cari Nama atau Singkatan">
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
            <p>Data Jembatan Kereta Api</p>
            <div class="d-flex align-item-center">
                @if($access['is_granted_create'])
                    <a class="btn-utama sml rnd me-2"
                       href="{{ route('traffic.railway-station.create', ['service_unit_id' => $service_unit->id]) }}">Tambah
                        <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                    </a>
                @endif
                <a class="btn-success sml rnd"
                   href="#"
                   id="btn-export">Export
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
                    <th class="text-center middle-header" width="10%">Kota</th>
                    <th class="text-center middle-header" width="10%">Kecamatan</th>
                    <th class="middle-header">Nama Stasiun</th>
                    <th class="text-center middle-header" width="10%">Singkatan</th>
                    <th class="text-center middle-header" width="10%">KM/HM</th>
                    <th class="text-center middle-header" width="10%">Status</th>
                    <th class="text-center middle-header" width="15%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-detail" tabindex="-1" aria-labelledby="modal-detail"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Stasiun Kereta
                        Api</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="area" class="form-label">Wilayah</label>
                                <input type="text" class="form-control" id="area" name="area" disabled>
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
                                <label for="district" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="district" name="district" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="city" class="form-label">Kota/Kabupaten</label>
                                <input type="text" class="form-control" id="city"
                                       name="city" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="station-name" class="form-label">Nama Stasiun</label>
                                <input type="text" class="form-control" id="station-name"
                                       name="station-name" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="nickname" class="form-label">Singkatan Stasiun</label>
                                <input type="text" class="form-control" id="nickname"
                                       name="nickname" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="height" class="form-label">Ketinggian</label>
                                <input type="number" step="any" class="form-control" id="height"
                                       name="height" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="type" class="form-label">Jenis Stasiun</label>
                                <input type="text" class="form-control" id="type"
                                       name="type" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="number" step="any" class="form-control" id="latitude" name="latitude"
                                       placeholder="Contoh: 7.1129489" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="number" step="any" class="form-control" id="longitude" name="longitude"
                                       placeholder="Contoh: 110.1129489" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status"
                                       name="status" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="station_class" class="form-label">Kelas Stasiun</label>
                                <input type="text" class="form-control" id="station_class"
                                       name="station_class" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" id="description"
                                          name="description" disabled></textarea>
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
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        let expiration = parseInt('{{ \App\Helper\Formula::ExpirationLimit }}');
        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail'));
        let grantedUpdate = '{{ $access['is_granted_update'] }}';
        let grantedDelete = '{{ $access['is_granted_delete'] }}';

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

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
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
                let area = data['area']['name'];
                let district = data['district']['name'];
                let city = data['district']['city']['name'];
                let name = data['name'];
                let nickname = data['nickname'];
                let stakes = data['stakes'];
                let height = data['height'];
                let latitude = data['latitude'];
                let longitude = data['longitude'];
                let type = data['type'];
                let station_class = data['station_class'];
                let description = data['description'];
                let status = data['status'] === 'aktif' ? 'Aktif' : 'Tidak Aktif';


                $('#area').val(area);
                $('#district').val(district);
                $('#city').val(city);
                $('#station-name').val(name);
                $('#nickname').val(nickname);
                $('#stakes').val(stakes);
                $('#height').val(height);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                $('#type').val(type);
                $('#status').val(status);
                $('#station_class').val(station_class);
                $('#description').val(description);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }

        function generateTableData() {
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
                        d.area = $('#area-option').val();
                        d.name = $('#name').val();
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
                    },
                    {
                        data: 'district.city.name',
                        name: 'district.city.name',
                        className: 'text-center'
                    },
                    {
                        data: 'district.name',
                        name: 'district.name',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'nickname',
                        name: 'nickname',
                        className: 'text-center'
                    },
                    {
                        data: 'stakes',
                        name: 'stakes',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            let elEdit = grantedUpdate === '1' ? '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' : '';
                            let elDelete = grantedDelete === '1' ? '<a href="#" class="btn-delete btn-table-action" data-id="' + data[
                                'id'] + '">Delete</a>' : '';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' +
                                data['id'] + '">Detail</a>' + elEdit + elDelete;
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
                    deleteEvent();
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

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            generateTableData();
            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-export').on('click', function (e) {
                e.preventDefault();
                let area = $('#area-option').val();
                let name = $('#name').val();
                let queryParam = '?area=' + area + '&name=' + name;
                let exportPath = path + '/excel' + queryParam;
                window.open(exportPath, '_blank');
            });
        });
    </script>
@endsection
