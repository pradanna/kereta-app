@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER SATUAN PELAYANAN</h1>
            <p class="mb-0">Manajemen Data Master Satuan Pelayanan</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('service-unit') }}">Satuan Pelayanan</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('service-unit.facility-certification', ['id' => $data->id]) }}">Sertifikasi
                        Sarana {{ $data->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Lokomotif</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="area-option" class="form-label d-none">Daerah Operasi</label>
                            <select class="select2 form-control" name="area-option" id="area-option"
                                    style="width: 100%;">
                                <option value="">Semua Daerah Operasi</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="storehouse-option" class="form-label d-none">Depo</label>
                            <select class="select2 form-control" name="storehouse-option" id="storehouse-option"
                                    style="width: 100%;">
                                <option value="">Semua Depo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="status-option" class="form-label d-none">Status</label>
                            <select class="select2 form-control" name="status-option" id="status-option"
                                    style="width: 100%;">
                                <option value="">Semua Status</option>
                                <option value="1">Berlaku</option>
                                <option value="0">Habis Masa Berlaku</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none"></label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Cari No. Sarana atau No. BA Pengujian">
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#" style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel w-100 shadow-sm">

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
        let areaPath = '{{ route('area') }}';

        function getDataStorehouse() {
            let areaID = $('#area-option').val();
            let serviceUnitID = '{{ $data->id }}';
            let storehousePath = '{{ route('storehouse') }}';
            let url = storehousePath + '/area?area=' + areaID + '&service_unit=' + serviceUnitID;
            return $.get(url)
        }

        function generateStorehouseOption() {
            let el = $('#storehouse-option');
            el.empty();
            let elOption = '<option value="">Semua Depo</option>';
            getDataStorehouse().then((response) => {
                const data = response['data'];
                $.each(data, function (k, v) {
                    elOption += '<option value="' + v['id'] + '">' + v['name'] + ' (' + v['storehouse_type']['name'] + ')</option>';
                });
            }).catch((e) => {
                alert('terjadi kesalahan server...')
            }).always(() => {
                el.append(elOption);
                $('.select2').select2({
                    width: 'resolve',
                });
            })
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            generateStorehouseOption();
            $('#area-option').on('change', function () {
                generateStorehouseOption();
            });
        });
    </script>
@endsection
