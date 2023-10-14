@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sertifikasi Sarana Peralatan Khusus</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm">
        <div class="title">
            <p>Sertifikasi Sarana Peralatan Khusus</p>
            <a class="btn-utama sml rnd " href="{{ route('facility-certification-special-equipment.create') }}">Tambah
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
                                <i class="material-symbols-outlined me-1" style="font-size: 14px; color: inherit">view_list</i>
                                Tampilan Grid
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center" id="pills-table-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab"
                                    aria-controls="pills-table" aria-selected="true">
                                <i class="material-symbols-outlined me-1" style="font-size: 14px; color: inherit">demography</i>
                                Tampilan Rekapitulasi
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-table" role="tabpanel"
                     aria-labelledby="pills-table-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group w-100">
                                <label for="area" class="form-label">Wilayah</label>
                                <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                    <option value="" selected>Semua</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table id="table-data" class="display table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Kepemilikan</th>
                            <th class="text-center">No. Sarana Baru</th>
                            <th class="text-center">No. Sarana Lama</th>
                            <th class="text-center">Wilayah</th>
                            <th class="text-center">Masa Berlaku Sarana</th>
                            <th class="text-center">No. BA Pengujian</th>
                            <th class="text-center">Akan Habis (Hari)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
    <script>
        let table;
        let path = '{{ route('facility-certification-special-equipment') }}';

        let areaPath = '{{ route('area') }}';

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
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, width: '30px'},
                    {data: 'ownership', name: 'ownership', width: '120px'},
                    {data: 'new_facility_number', name: 'new_facility_number', width: '100px'},
                    {data: 'old_facility_number', name: 'old_facility_number', width: '100px'},
                    {data: 'area.name', name: 'area.name', width: '150px',},
                    {
                        data: 'service_expired_date', name: 'service_expired_date', render: function (data) {
                            const v = new Date(data);
                            return v.toLocaleDateString('id-ID', {
                                month: '2-digit',
                                year: 'numeric',
                                day: '2-digit'
                            }).split('/').join('-')
                        }, width: '140px',
                    },
                    {data: 'testing_number', name: 'testing_number', width: '150px',},
                    {
                        data: 'expired_in', name: 'expired_in', render: function (data) {
                            return data + ' hari';
                        }, width: '80px',
                    },
                    {
                        data: 'status', name: 'status', render: function (data) {
                            if (data === 'valid') {
                                return 'Berlaku';
                            }
                            return 'Habis Masa Berlaku';
                        }, width: '100px',
                    },
                    {
                        data: null, render: function (data) {
                            return '<a href="#" class="btn-edit me-1" data-id="' + data['id'] + '">Edit</a>' +
                                '<a href="#" class="btn-delete" data-id="' + data['id'] + '">Delete</a>'
                        }, orderable: false, width: '120px',
                    }
                ],
                columnDefs: [
                    {
                        targets: '_all',
                        className: 'text-center'
                    }
                ]
            });
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            generateTableFacilityCertification();
        });
    </script>
@endsection
