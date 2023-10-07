@extends('layout')

@section('content')
    <a href="{{ route('service-unit.create') }}">Tambah</a>
    <table id="example" class="display" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
@endsection

@section('js')
    <script>
        let table;
        let path = '{{ route('service-unit') }}';
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
                    {data: 'name', name: 'name'},
                ],
                paging: true,
            })
        })
    </script>
@endsection
