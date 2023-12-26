@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA KERETA</h1>
            <p class="mb-0">Manajemen Data Spesifikasi Teknis Sarana Kereta</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.technical-specification') }}">Spesifikasi Teknis
                        Sarana</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kereta</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Spesifikasi Teknis Sarana Kereta</p>
            @if($access['is_granted_create'])
                <a class="btn-utama sml rnd " href="{{ route('means.technical-specification.train.add') }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
            @endif
        </div>
        <div class="isi">
            <table id="table-data" class="display table w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%">#</th>
                    <th class="middle-header">Jenis Kereta</th>
                    <th class="text-center middle-header" width="12%">Spesifikasi Umum</th>
                    <th class="text-center middle-header" width="12%">Dokumen</th>
                    <th class="text-center middle-header" width="12%">Gambar</th>
                    {{--                    <th class="text-center middle-header" width="15%">Jenis Sarana</th>--}}
                    {{--                    <th class="text-center middle-header">Identitas Sarana</th>--}}
                    {{--                    <th class="text-center middle-header" width="10%">Berat Kosong (Ton)</th>--}}
                    {{--                    <th class="text-center middle-header" width="10%">Kecepatan Maksimum (Km/jam)</th>--}}
                    {{--                    <th class="text-center middle-header" width="12%">Jumlah Tempat Duduk</th>--}}
                    {{--                    <th class="text-center middle-header" width="12%">Jenis AC</th>--}}
                    {{--                    <th class="text-center" colspan="6">Dimensi</th>--}}
                    <th class="text-center middle-header" width="15%">Aksi</th>
                </tr>
                {{--                <tr>--}}
                {{--                    <th class="text-center middle-header">Panjang (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Lebar (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Tinggi (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Tinggi Coupler (mm)</th>--}}
                {{--                    <th class="text-center middle-header">Beban Gandar (Ton)</th>--}}
                {{--                    <th class="text-center middle-header">Lebar Spoor (mm)</th>--}}
                {{--                </tr>--}}
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
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Spesifikasi Teknis
                        Sarana Kereta</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="train_type" class="form-label">Jenis Kereta</label>
                                <input type="text" class="form-control" id="train_type"
                                       name="train_type"
                                       disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="empty_weight" class="form-label">Berat Kosong (Ton)</label>
                                <input type="number" step="any" class="form-control" id="empty_weight"
                                       name="empty_weight"
                                       placeholder="Berat Kosong" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="passenger_capacity" class="form-label">Kapasitas Penumpang</label>
                                <input type="number" step="any" class="form-control" id="passenger_capacity"
                                       name="passenger_capacity"
                                       placeholder="Kapasitas Penumpang" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="maximum_speed" class="form-label">Kecepatan Maksimum (Km/Jam)</label>
                                <input type="number" step="any" class="form-control" id="maximum_speed"
                                       name="maximum_speed"
                                       placeholder="Kecepatan Maksimum (VMax)" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="air_conditioner" class="form-label">Jenis AC</label>
                                <input type="text" class="form-control" id="air_conditioner"
                                       name="air_conditioner"
                                       placeholder="Jenis AC" disabled>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Dimensi</p>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="long" class="form-label">Panjang Kereta (mm)</label>
                                <input type="number" step="any" class="form-control" id="long" name="long"
                                       placeholder="Panjang Kereta" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="width" class="form-label">Lebar Kereta (mm)</label>
                                <input type="number" step="any" class="form-control" id="width" name="width"
                                       placeholder="Lebar Kereta" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="height" class="form-label">Tinggi Kereta (mm)</label>
                                <input type="number" step="any" class="form-control" id="height" name="height"
                                       placeholder="Tinggi Kereta" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="coupler_height" class="form-label">Tinggi Alat Perangkai (mm)</label>
                                <input type="number" step="any" class="form-control" id="coupler_height"
                                       name="coupler_height"
                                       placeholder="Tinggi Alat Perangkai" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="axle_load" class="form-label">Beban Gandar (Ton)</label>
                                <input type="number" step="any" class="form-control" id="axle_load" name="axle_load"
                                       placeholder="Beban Gandar" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="spoor_width" class="form-label">Lebar Spoor (mm)</label>
                                <input type="number" step="any" class="form-control" id="spoor_width" name="spoor_width"
                                       placeholder="Lebar Spoor" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="description"
                                          name="description"
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
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <style>
        .middle-header {
            vertical-align: middle;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';
        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));
        let grantedUpdate = '{{ $access['is_granted_update'] }}';
        let grantedDelete = '{{ $access['is_granted_delete'] }}';

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
                let trainType = data['train_type']['code'] + ' (' + data['train_type']['name'] + ')';
                let emptyWeight = data['empty_weight'];
                let maximumSpeed = data['maximum_speed'];
                let passengerCapacity = data['passenger_capacity'];
                let airConditioner = data['air_conditioner'];
                let long = data['long'];
                let width = data['width'];
                let height = data['height'];
                let couplerHeight = data['coupler_height'];
                let axleLoad = data['axle_load'];
                let spoorWidth = data['spoor_width'];
                let description = data['description'];
                $('#train_type').val(trainType);
                $('#empty_weight').val(emptyWeight);
                $('#maximum_speed').val(maximumSpeed);
                $('#passenger_capacity').val(passengerCapacity);
                $('#air_conditioner').val(airConditioner);
                $('#long').val(long);
                $('#width').val(width);
                $('#height').val(height);
                $('#coupler_height').val(couplerHeight);
                $('#axle_load').val(axleLoad);
                $('#spoor_width').val(spoorWidth);
                $('#description').val(description);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
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

        function generateTable() {
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
                    className: 'text-center',
                },
                    {
                        data: 'train_type',
                        name: 'train_type',
                        render: function (data) {
                            return data['code'] + ' (' + data['name'] + ')';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data['id'] + '">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            let url = path + '/' + data['id'] + '/dokumen';
                            return '<a href="' + url + '" class="btn-document btn-table-action">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data) {
                            let url = path + '/' + data['id'] + '/gambar';
                            return '<a href="' + url + '" class="btn-image btn-table-action">Lihat</a>';
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            let elEdit = grantedUpdate === '1' ? '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' : '';
                            let elDelete = grantedDelete === '1' ? '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>' : '';
                            if (grantedUpdate !== '1' && grantedDelete !== '1') {
                                return '<span>-</span>';
                            }
                            return elEdit + elDelete;
                        },
                        orderable: false,
                        className: 'text-center'
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
            });
        }

        $(document).ready(function () {
            generateTable();
        });
    </script>
@endsection
