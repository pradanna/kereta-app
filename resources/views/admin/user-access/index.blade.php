@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="page-title-container">
            <h1 class="h1">MANAJEMEN AKSES PENGGUNA APLIKASI</h1>
            <p class="mb-0">Manajemen Data Akses Pengguna Aplikasi</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Pengguna Aplikasi</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Akses Pengguna Aplikasi</p>
        </div>
        <div class="isi">
            <div class="form-group w-100 mb-3">
                <label for="user-option" class="form-label">Pengguna Aplikasi</label>
                <select class="select2 form-control" name="user-option" id="user-option"
                        style="width: 100%;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                    @endforeach
                </select>
            </div>
            <hr>
            <div id="panel-menus"></div>
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
        let path = '{{ route('user-access') }}';
        let pathAppMenu = '{{ route('user-access.menu') }}';

        async function getAppMenu() {
            let parentEl = $('#panel-menus');
            try {
                parentEl.empty();
                let response = await $.get(pathAppMenu);
                let data = response['data'];
                parentEl.append(generateElement(data));
                console.log(response);
            }catch (e) {
                let error_message = JSON.parse(e.responseText);
                ErrorAlert('Error', error_message.message);
            }
        }

        function generateElement(data = []) {
            let result = '';
            $.each(data, function (k, v) {
                result += '<div class="mb-2">' +
                    '<label for="menu" class="form-label d-block fw-bold" style="color: #1a202c">'+v['name']+'</label>' +
                    '<div class="form-check form-check-inline">' +
                    '  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="">' +
                    '  <label class="form-check-label" for="inlineCheckbox1">Tambah</label>' +
                    '</div>' +
                    '<div class="form-check form-check-inline">' +
                    '  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="">' +
                    '  <label class="form-check-label" for="inlineCheckbox1">Edit</label>' +
                    '</div>' +
                    '<div class="form-check form-check-inline">' +
                    '  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="">' +
                    '  <label class="form-check-label" for="inlineCheckbox1">Hapus</label>' +
                    '</div>' +
                    '</div>';
            });
            return result;
        }

        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            getAppMenu();
        })
    </script>
@endsection
