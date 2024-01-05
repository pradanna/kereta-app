@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">LAPORAN BULANAN K3L</h1>
            <p class="mb-0">Manajemen Data Laporan Bulanan K3L</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.work-safety') }}">Keselamatan dan Kesehatan Kerja
                        (K3)</a></li>
                <li class="breadcrumb-item active" aria-current="page">Laporan Bulanan K3L</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="month" class="form-label d-none">Masa Berlaku</label>
                            <input type="text" class="form-control datepicker" id="month"
                                   name="month" placeholder="mm-yyyy" value="{{ \Carbon\Carbon::now()->format('F Y') }}">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none">Param</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Cari Nama Laporan">
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
            <p>Data Laporan Bulanan K3L</p>
            <div class="d-flex align-item-center">
                <a class="btn-utama sml rnd me-2"
                   href="{{ route('means.work-safety.report.add') }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="12%">Bulan</th>
                    <th>Nama Laporan</th>
                    <th width="12%">Dokumen</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
            integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        let table;
        function generateTable() {
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
                        d.name = $('#name').val();
                        d.date = $('#month').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center middle-header',
                },
                    {
                        data: 'date',
                        name: 'date',
                        className: 'text-center middle-header',
                        render: function (data) {
                            let date = new Date(data)
                            return date.toLocaleString('id-ID', {
                                month: 'long',
                                year: 'numeric',
                            })
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'middle-header',
                    },
                    {
                        data: null,
                        name: null,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let urlDocument = data['document'];
                            return '<a href="'+urlDocument+'" target="_blank" class="btn-detail me-2 btn-table-action" data-id="' +
                                data['id'] + '">Unduh</a>'
                        }
                    },
                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false,
                        className: 'text-center middle-header',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function (setting) {
                    // eventOpenDetail();
                    deleteEvent();
                },
                dom: 'ltrip'
            });
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

        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'MM yyyy',
                viewMode: 'months',
                minViewMode: 'months',
                locale: 'id',
                autoclose: true,
                // startDate: new Date(),
            });
            generateTable();
            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });
        });
    </script>
@endsection
