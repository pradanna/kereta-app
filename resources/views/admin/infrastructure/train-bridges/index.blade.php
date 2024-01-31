@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">JEMBATAN KERETA API {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Jembatan Kereta Api {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('infrastructure') }}">Prasarana</a></li>
                <li class="breadcrumb-item active" aria-current="page">Jembatan Kereta
                    Api {{ $service_unit->name }}</li>
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
                                   placeholder="Cari KM/HM atau Koridor">
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
                       href="{{ route('infrastructure.train.bridges.create', ['service_unit_id' => $service_unit->id]) }}">Tambah
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
                    <th class="text-center middle-header" width="10%">Lintas</th>
                    <th class="text-center middle-header" width="10%">Petak</th>
                    <th class="text-center middle-header" width="10%">KM/HM</th>
                    <th class="middle-header">Koridor</th>
                    <th class="text-center middle-header" width="12%">Tahun Di Pasang</th>
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
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Jembatan Kereta
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
                            <div class="form-group w-100">
                                <label for="track" class="form-label">Lintas</label>
                                <input type="text" class="form-control" id="track" name="track" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="sub_track" class="form-label">Petak</label>
                                <input type="text" class="form-control" id="sub_track" name="sub_track" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="stakes" class="form-label">KM/HM</label>
                                <input type="text" class="form-control" id="stakes" name="stakes" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="corridor" class="form-label">Koridor</label>
                                <input type="text" class="form-control" id="corridor"
                                       name="corridor" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="reference_number" class="form-label">No. BH</label>
                                <input type="text" class="form-control" id="reference_number"
                                       name="reference_number" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="building_type" class="form-label">Jenis Bangunan</label>
                                <input type="text" class="form-control" id="building_type"
                                       name="building_type" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="span" class="form-label">Bentang</label>
                                <input type="text" class="form-control" id="span"
                                       name="span" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="installed_date" class="form-label">Di Pasang</label>
                                <input type="text" class="form-control datepicker" id="installed_date"
                                       name="installed_date" placeholder="dd-mm-yyyy" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="replaced_date" class="form-label">Di Ganti</label>
                                <input type="text" class="form-control datepicker" id="replaced_date"
                                       name="replaced_date" placeholder="dd-mm-yyyy" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="strengthened_date" class="form-label">Di Perkuat</label>
                                <input type="text" class="form-control datepicker" id="strengthened_date"
                                       name="strengthened_date" placeholder="dd-mm-yyyy" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="bridge_type" class="form-label">Jembatan</label>
                                <input type="text" class="form-control" id="bridge_type"
                                       name="bridge_type" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="w-100">
                                <label for="volume" class="form-label">Volume Andas (Buah)</label>
                                <input type="number" step="any" class="form-control" id="volume"
                                       name="volume" value="0" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <label for="bearing" class="form-label">Jumlah Bantalan (Buah)</label>
                                <input type="number" step="any" class="form-control" id="bearing"
                                       name="bearing" value="0" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="w-100">
                                <label for="bolt" class="form-label">Jumlah Baut (Buah)</label>
                                <input type="number" step="any" class="form-control" id="bolt"
                                       name="bolt" value="0" disabled>
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
        let table;
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
                let subTrack = data['sub_track']['code'];
                let track = data['track']['code'];
                let stakes = data['stakes'];
                let reference_number = data['reference_number'];
                let corridor = data['corridor'];
                let bridge_type = data['bridge_type'];
                let building_type = data['building_type'];
                let span = data['span'];
                let installed_date = data['installed_date'];
                let replaced_date = data['replaced_date'];
                let strengthened_date = data['strengthened_date'];
                let volume = data['volume'];
                let bolt = data['bolt'];
                let bearing = data['bearing'];
                let description = data['description'];

                let iDate = new Date(installed_date);
                let rDate = new Date(replaced_date);
                let sDate = new Date(strengthened_date);

                let iDateValue = iDate.toLocaleDateString('id-ID', {
                    year: 'numeric',
                });
                let rDateValue = rDate.toLocaleDateString('id-ID', {
                    year: 'numeric',
                });
                let sDateValue = sDate.toLocaleDateString('id-ID', {
                    year: 'numeric',
                });
                $('#area').val(area);
                $('#sub_track').val(subTrack);
                $('#track').val(track);
                $('#stakes').val(stakes);
                $('#reference_number').val(reference_number);
                $('#corridor').val(corridor);
                $('#bridge_type').val(bridge_type);
                $('#building_type').val(building_type);
                $('#span').val(span);
                $('#installed_date').val(iDateValue);
                $('#replaced_date').val(rDateValue);
                $('#strengthened_date').val(sDateValue);
                $('#volume').val(volume);
                $('#bolt').val(bolt);
                $('#bearing').val(bearing);
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
                        data: 'track.code',
                        name: 'track.code',
                        className: 'text-center'
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center'
                    },
                    {
                        data: 'stakes',
                        name: 'stakes',
                        className: 'text-center'
                    },
                    {
                        data: 'corridor',
                        name: 'corridor',
                    },
                    {
                        data: 'installed_date',
                        name: 'installed_date',
                        render: function (data) {
                            const v = new Date(data);
                            return v.toLocaleDateString('id-ID', {
                                year: 'numeric',
                            })
                        },
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
