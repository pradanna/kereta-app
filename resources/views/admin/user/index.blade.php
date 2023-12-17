@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title-container">
            <h1 class="h1">MANAJEMEN PENGGUNA APLIKASI</h1>
            <p class="mb-0">Manajemen Data Pengguna Aplikasi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Pengguna Aplikasi</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Pengguna Aplikasi</p>
            <a class="btn-utama sml rnd " href="{{ route('user.create') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="15%">Username</th>
                    <th width="15%">Nickname</th>
                    <th width="20%">Wilayah</th>
                    <th>Hak Akses</th>
                    <th width="12%" class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('user') }}';

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
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'nickname',
                        name: 'nickname'
                    },
                    {
                        data: null,
                        name: null,
                        render: function (data) {
                            if (data['service_unit'] !== null) {
                                value = data['service_unit']['name'];
                            }
                            return value;
                        }
                    },
                    {
                        data: 'role',
                        name: 'role',
                        render: function (data) {
                            let value = '-';
                            switch (data) {
                                case 'admin-area':
                                    value = 'Admin Daerah Operasi (DAOP)';
                                    break;
                                case 'chief-area':
                                    value = 'Kepala Daerah Operasi (DAOP)';
                                    break;
                                case 'admin-service-unit':
                                    value = 'Admin Satuan Pelayanan (SATPEL)';
                                    break;
                                case 'chief-service-unit':
                                    value = 'Kepala Satuan Pelayanan (SATPEL)';
                                    break;
                                default:
                                    break;
                            }
                            return value;
                        },
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
                    targets: '_all',
                    className: 'text-center'
                }],
                paging: true,
                "fnDrawCallback": function (setting) {
                    deleteEvent();
                }
            })
        }

        $(document).ready(function () {
            generateTable();
        })
    </script>
@endsection
