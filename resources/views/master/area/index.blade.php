@extends('layout')

@section('content')
    <a href="{{ route('area.create') }}">Tambah</a>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Satuan Pelayanan</th>
            <th>Nama</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('js')
    <script>
        let table;
        let path = '{{ route('area') }}';
        $(document).ready(function () {
            table = $('#example').DataTable({
                scrollX: true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
                    {data: 'service_unit.name', name: 'service_unit.name'},
                    {data: 'name', name: 'name'},
                ],
                paging: true,
            })
        })
    </script>
@endsection
