@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Satuan Pelayanan</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Satuan Pelayanan</p>
            <a class="btn-utama sml rnd " href="{{ route('service-unit.create') }}">Tambah Data <i
                    class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i></a>
        </div>


        <div class="isi">

            <table id="table-data" class="display table table-striped w-100">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">#</th>
                        <th>Nama</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let table;
        let path = '{{ route('service-unit') }}';
        $(document).ready(function() {
            table = $('#table-data').DataTable({
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
                        data: null,
                        render: function(data) {
                            return '<a href="#" class="btn-edit me-1" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete" data-id="' + data['id'] +
                                '">Delete</a>'
                        },
                        orderable: false
                    }
                ],
                columnDefs: [{
                    targets: [0, 2],
                    className: 'text-center'
                }],
                paging: true,
            })
        })
    </script>
@endsection
