<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
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
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
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
</body>
</html>
