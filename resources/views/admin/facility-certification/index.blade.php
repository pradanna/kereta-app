@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sertifikasi Sarana</li>
            </ol>
        </nav>
    </div>
    <div class="card w-100 shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div class="flex-grow-1">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active d-flex align-items-center" id="pills-table-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab"
                                aria-controls="pills-table" aria-selected="true">
                                <span class="material-icons-round me-1" style="font-size: 14px;">view_list</span>
                                Tampilan Grid
                            </button>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('facility-certification.create') }}"
                    class="btn btn-primary d-flex align-items-center justify-content-center">
                    <span class="material-icons-round me-1" style="font-size: 14px;">add</span>
                    Tambah
                </a>
            </div>
            <hr>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group w-100">
                                <label for="facility_type" class="form-label">Tipe Sarana</label>
                                <select class="select2 form-control" name="facility_type" id="facility_type"
                                    style="width: 100%;">
                                    <option value="" selected>Semua</option>
                                    @foreach ($facility_types as $facility_type)
                                        <option value="{{ $facility_type->id }}">{{ $facility_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
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
                        <div class="col-4">
                            <div class="form-group w-100">
                                <label for="storehouse" class="form-label">Depo Induk</label>
                                <select class="select2 form-control" name="storehouse" id="storehouse" style="width: 100%;">
                                    <option value="" selected>Semua</option>
                                    {{--                                    @foreach ($cities as $city) --}}
                                    {{--                                        <option value="{{ $city->id }}">{{ $city->name }}</option> --}}
                                    {{--                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table id="table-data" class="display table table-striped w-100">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tipe Sarana</th>
                                <th class="text-center">Kepemilikan</th>
                                <th class="text-center">No. Sarana</th>
                                <th class="text-center">Wilayah</th>
                                <th class="text-center">Depo Induk</th>
                                <th class="text-center">Mulai Dinas</th>
                                <th class="text-center">Masa Berlaku Sarana</th>
                                <th class="text-center">No. BA Pengujian</th>
                                <th class="text-center">Akan Habis (Hari)</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger</td>
                                <td>Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                                <td>5421</td>
                                <td>t.nixon@datatables.net</td>
                                <td>t.nixon@datatables.net</td>
                                <td>t.nixon@datatables.net</td>
                                <td>t.nixon@datatables.net</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                                <td>5421</td>
                                <td>t.nixon@datatables.net</td>
                                <td>t.nixon@datatables.net</td>
                                <td>t.nixon@datatables.net</td>
                                <td>t.nixon@datatables.net</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script>
        let table;
        let path = '{{ route('facility-certification') }}';

        function generateTableFacilityCertification() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                columnDefs: [{
                        width: '30px',
                        targets: 0,
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        width: '250px',
                        targets: 1,
                        className: 'text-center'
                    },
                    {
                        width: 120,
                        targets: 2,
                        className: 'text-center'
                    },
                    {
                        width: 150,
                        targets: 3,
                        className: 'text-center'
                    },
                    {
                        width: 180,
                        targets: 4,
                        className: 'text-center'
                    },
                    {
                        width: 120,
                        targets: 5,
                        className: 'text-center'
                    },
                    {
                        width: 100,
                        targets: 6,
                        className: 'text-center'
                    },
                    {
                        width: 100,
                        targets: 7,
                        className: 'text-center'
                    },
                    {
                        width: 250,
                        targets: 8,
                        className: 'text-center'
                    },
                    {
                        width: 120,
                        targets: 9,
                        className: 'text-center'
                    },
                    {
                        width: 120,
                        targets: 10,
                        className: 'text-center'
                    },
                    {
                        width: 150,
                        targets: 10,
                        className: 'text-center'
                    },
                ]
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            generateTableFacilityCertification();
        });
    </script>
@endsection
