@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER PERLINTASAN {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Master Perlintasan {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master-data') }}">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('track') }}">Perlintasan {{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-3">
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
                    <div class="col-9">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none"></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Cari Kode atau Nama Perlintasan">
                        </div>
                    </div>

                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#" style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="title">
            <p>Data Perlintasan</p>
            <div class="d-flex align-item-center">
                <a class="btn-utama sml rnd me-2" href="{{ route('track.service-unit.create', ['service_unit_id' => $service_unit->id]) }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
                <a class="btn-success sml rnd" href="#" id="btn-export">
                    Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="15%">Wilayah</th>
                    <th width="12%">Kode</th>
                    <th>Nama</th>
                    <th width="10%" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';

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
                        d.area = $('#area').val();
                        d.name = $('#name').val();
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
                        data: 'code',
                        name: 'code'
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
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false
                    }
                ],
                columnDefs: [{
                    targets: [0, 1, 2, 4],
                    className: 'text-center'
                }],
                paging: true,
                "fnDrawCallback": function (setting) {
                    deleteEvent();
                },
                dom: 'ltrip'
            })

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });
            $('#btn-export').on('click', function (e) {
                e.preventDefault();
                let area = $('#area').val();
                let name = $('#name').val();
                let queryParam = '?area=' + area + '&name=' + name;
                // window.open(exportPath, '_blank');
            });
        })
    </script>
@endsection
