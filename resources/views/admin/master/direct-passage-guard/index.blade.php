@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER DATA PENJAGA JALUR LINTASAN (PJL)</h1>
            <p class="mb-0">Manajemen Data Master Data Penjaga Jalur Lintasan (PJL)</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Penjaga Jalur Lintasan (PJL)</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Penjaga Jalur Lintasan (PJL)</p>
            <a class="btn-utama sml rnd " href="{{ route('direct-passage-human-resource.create') }}">Tambah
                <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
            </a>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center middle-header">#</th>
                    <th class="middle-header">Nama</th>
                    <th width="15%" class="text-center middle-header">Kartu Kecakapan</th>
                    <th width="18%" class="text-center middle-header">No. Diklat / Bintek JPL</th>
                    <th width="15%" class="text-center middle-header">Tanggal Kadaluarsa</th>
                    <th width="10%" class="text-center middle-header">Kadaluarsa</th>
                    <th width="10%" class="text-center middle-header">Aksi</th>
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
        let path = '{{ route('direct-passage-human-resource') }}';

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
                    orderable: false
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'skill_card_id',
                        name: 'skill_card_id',
                        render: function (data) {
                            if (data === '') {
                                return '-';
                            }
                            return data;
                        },
                    },
                    {
                        data: 'training_card_id',
                        name: 'training_card_id',
                        render: function (data) {
                            if (data === '') {
                                return '-';
                            }
                            return data;
                        },
                    },
                    {
                        data: 'card_expired',
                        name: 'card_expired',
                        render: function (data) {
                            if (data === null) {
                                return '-';
                            }
                            const v = new Date(data);
                            return v.toLocaleDateString('id-ID', {
                                month: '2-digit',
                                year: 'numeric',
                                day: '2-digit'
                            }).split('/').join('-')
                        },
                    },
                    {
                        data: null,
                        name: null,
                        render: function (data) {
                            if (data['card_expired'] === null) {
                                return '-';
                            }
                            let value = 'Berlaku';
                            if (data['expired_in'] <= 0) {
                                value = 'Kadaluarsa';
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
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false
                    }
                ],
                columnDefs: [{
                    targets: [0, 2, 3, 4, 5, 6],
                    className: 'text-center'
                }],
                paging: true,
                "fnDrawCallback": function (setting) {
                    deleteEvent();
                }
            })
        })
    </script>
@endsection
