@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER SUB JENIS GERBONG</h1>
            <p class="mb-0">Manajemen Data Master Sub Jenis Gerbong</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master-data') }}">Master Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sub Jenis Gerbong</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Jenis Sub Jenis Gerbong</p>
            @if($access['is_granted_create'])
                <a class="btn-utama sml rnd " href="{{ route('wagon-sub-type.create') }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
            @endif
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="12%" class="text-center">Jenis</th>
                    <th width="12%" class="text-center">Kode</th>
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
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '{{ route('wagon-sub-type') }}';
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
                        data: 'wagon_type.code',
                        name: 'wagon_type.code'
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
                            let elEdit = grantedUpdate === '1' ? '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' : '';
                            let elDelete = grantedDelete === '1' ? '<a href="#" class="btn-delete btn-table-action" data-id="' + data[
                                'id'] + '">Delete</a>' : '';
                            if (elEdit === '' && elDelete === '') {
                                return '-';
                            }
                            return  elEdit + elDelete;
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
                }
            })
        })
    </script>
@endsection
