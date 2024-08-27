@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">PERLINTASAN KERETA API (JPL) {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Perlintasan Kereta Api (JPL) {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('means.direct-passage.service-unit', ['service_unit_id' => $service_unit->id]) }}">Perlintasan
                        Kereta Api (JPL) {{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">(PLH)</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Peristiwa Luar Biasa Hebat (PLH) JPL {{ $data->name }}</p>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                    <tr>
                        <th class="text-center middle-header" width="5%" rowspan="2">#</th>
                        <th class="text-center middle-header" width="12%" rowspan="2">KM/HM</th>
                        <th class="text-center middle-header" width="15%" rowspan="2">Waktu</th>
                        <th class="middle-header" rowspan="2">Jenis Laka</th>
                        <th class="text-center middle-header" colspan="3">Korban Jiwa</th>
                    </tr>
                    <tr>
                        <th class="text-center middle-header" width="8%">Luka-Luka</th>
                        <th class="text-center middle-header" width="8%">Meninggal</th>
                        <th class="text-center middle-header" width="8%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->accidents as $accident)
                        <tr>
                            <td class="text-center middle-header" width="5%">{{ $loop->index + 1 }}</td>
                            <td class="text-center middle-header" width="12%">{{ $accident->stakes }}</td>
                            <td class="text-center middle-header" width="15%">{{ $accident->date }}</td>
                            <td class="middle-header">{{ $accident->accident_type }}</td>
                            <td class="text-center middle-header">{{ $accident->injured }}</td>
                            <td class="text-center middle-header">{{ $accident->died }}</td>
                            <td class="text-center middle-header">{{ $accident->injured + $accident->died }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        $(document).ready(function() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                columnDefs: [],
                paging: true,
            })
        });
    </script>
@endsection
