@extends('layout')

@section('content')
    <a href="{{ route('storehouse.create') }}">Tambah</a>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Daerah Operasi</th>
            <th>Tipe</th>
            <th>Nama</th>
            <th>Kota</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('js')
    <script>
        let table;
        let path = '{{ route('storehouse') }}';
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
                    {data: 'area.name', name: 'area.name'},
                    {data: 'storehouse_type.name', name: 'storehouse_type.name'},
                    {data: 'name', name: 'name'},
                    {data: 'city.name', name: 'city.name'},
                ],
                paging: true,
            })
        })
    </script>
@endsection
