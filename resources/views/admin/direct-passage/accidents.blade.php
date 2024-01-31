@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">JALUR PERLINTASAN LANGSUNG</h1>
            <p class="mb-0">Manajemen Data Jalur Perlintasan Langsung</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('direct-passage') }}">Jalur Perlintasan Langsung (JPL)</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">PLH {{ $data->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Peristiwa Luar Biasa Hebat (PLH) JPL {{ $data->name }} (KM {{ $data->stakes }})</p>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%" rowspan="2">#</th>
                    <th class="text-center middle-header" width="12%" rowspan="2">Tanggal</th>
                    <th class="text-center middle-header" width="8%" rowspan="2">Jam</th>
                    <th class="middle-header" rowspan="2">Jenis Kereta Api</th>
                    <th class="text-center middle-header" width="15%" rowspan="2">Jenis Laka</th>
                    <th class="text-center middle-header" colspan="3">Korban Jiwa</th>
                </tr>
                <tr>
                    <th class="text-center middle-header" width="8%">Luka-Luka</th>
                    <th class="text-center middle-header" width="8%">Meninggal</th>
                    <th class="text-center middle-header" width="8%">Total</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
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
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        $(document).ready(function () {
            table = $('#table-data').Datatable()
        });
    </script>
@endsection
