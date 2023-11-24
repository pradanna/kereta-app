@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">REKAPITULASI JALUR PERLINTASAN LANGSUNG (JPL)</h1>
            <p class="mb-0">Rekapitulasi Jalur Perlintasan Langsun (JPL)</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekapitulasi JPL</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Rekapitulasi Jalur Perlintasan Langsung (JPL)</p>

        </div>
        <div class="isi">
            <p style="font-size: 14px; color: #777777; font-weight: bold;">Rekapitulasi Jumlah Sarana</p>
            <table id="table-summary" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="middle-header">Wilayah</th>
                    <th class="text-center middle-header" width="8%">OP (PT.KAI)</th>
                    <th class="text-center middle-header" width="8%">JJ (PT.KAI)</th>
                    <th class="text-center middle-header" width="8%">Instansi Lain</th>
                    <th class="text-center middle-header" width="8%">Resmi Tidak Dijaga</th>
                    <th class="text-center middle-header" width="8%">Liar</th>
                    <th class="text-center middle-header" width="8%">Total</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th class="middle-header">Jumlah</th>
                    <th class="text-center middle-header" width="8%">0</th>
                    <th class="text-center middle-header" width="8%">0</th>
                    <th class="text-center middle-header" width="8%">0</th>
                    <th class="text-center middle-header" width="8%">0</th>
                    <th class="text-center middle-header" width="8%">0</th>
                    <th class="text-center middle-header" width="8%">0</th>
                </tr>
                </tfoot>
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
        let path = '{{ route('summary-direct-passage') }}';
        function generateSummary() {
            $('#table-summary').DataTable({
                "aaSorting": [],
                "order": [],
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                    }
                },
                columns: [
                    {data: 'area', name: 'area',},
                    {data: 'operator', name: 'operator', className: 'text-center'},
                    {data: 'unit_track', name: 'unit_track', className: 'text-center'},
                    {data: 'institution', name: 'institution', className: 'text-center'},
                    {data: 'unguarded', name: 'unguarded', className: 'text-center'},
                    {data: 'illegal', name: 'illegal', className: 'text-center'},
                    {data: 'total', name: 'total', className: 'text-center fw-bold'},
                ],
                columnDefs: [
                    {
                        target: '_all',
                        orderable: false
                    }
                ],
                dom: 't',
                footerCallback: function (row, data, start, end, display) {
                    let api = this.api();

                    let intVal = function (i) {
                        return typeof i === 'string'
                            ? i.replace(/[\$,]/g, '') * 1
                            : typeof i === 'number'
                                ? i
                                : 0;
                    };
                    for (let i = 1; i < 7; i++) {
                        total = api
                            .column(i)
                            .data()
                            .reduce((a, b) => intVal(a) + intVal(b), 0);
                        api.column(i).footer().innerHTML = total;
                    }

                }
            });
        }

        $(document).ready(function () {
            generateSummary();
        });
    </script>
@endsection
