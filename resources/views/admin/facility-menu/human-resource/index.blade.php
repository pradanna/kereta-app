@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SDM {{ $type }} {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data SDM {{ $type }} {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">SDM {{ $type }} {{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="row flex-grow-1 gx-2">
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="area-option" class="form-label d-none">Daerah Operasi</label>
                            <select class="select2 form-control" name="area-option" id="area-option" style="width: 100%;">
                                <option value="">Semua Daerah Operasi</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
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
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="name" class="form-label d-none"></label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Cari Nama SDM">
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#"
                        style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel w-100 shadow-sm">
        <div class="title">
            <p>Data SDM</p>
            <div class="d-flex align-item-center">
                @if ($access['is_granted_create'])
                    <a class="btn-utama sml rnd me-2"
                        href="{{ route('means.human-resource.create', ['service_unit_id' => $service_unit->id, 'slug' => $slug]) }}">Tambah
                        <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                    </a>
                @endif
                <a class="btn-success sml rnd" href="#" id="btn-export">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table w-100">
                <thead>
                    <tr>
                        <th class="text-center middle-header" width="5%">#</th>
                        <th class="text-center middle-header" width="10%">Wilayah</th>
                        <th class="middle-header">Nama</th>
                        <th class="text-center middle-header" width="12%">Nomor Identitas</th>
                        <th class="text-center middle-header" width="12%">Unit Pengajuan Sertifikasi</th>
                        <th class="text-center middle-header" width="12%">Kodefikasi Sertifikat</th>
                        <th class="text-center middle-header" width="10%">Masa Berlaku</th>
                        <th class="text-center middle-header" width="5%">Akan Habis (Hari)</th>
                        <th class="text-center middle-header" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-detail" tabindex="-1" aria-labelledby="modal-detail" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Safety
                        Assessment</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="area" class="form-label">Wilayah (Daerah Operasi)</label>
                                <input type="text" class="form-control" id="area" name="area" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="human-name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="human-name" name="human-name" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="birth_place" name="birth_place" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control datepicker" id="date_of_birth"
                                    name="date_of_birth" placeholder="dd-mm-yyyy" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="identity_number" class="form-label">No. Identitas</label>
                                <input type="text" class="form-control" id="identity_number" name="identity_number"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="certification_unit" class="form-label">Unit Pengajuan Sertifikasi</label>
                                <input type="text" class="form-control" id="certification_unit"
                                    name="certification_unit" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="certification_number" class="form-label">Kodefikasi Sertifikat</label>
                                <input type="text" class="form-control" id="certification_number"
                                    name="certification_number" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="expired_date" class="form-label">Tanggal Habis Berlaku</label>
                                <input type="text" class="form-control datepicker" id="expired_date"
                                    name="expired_date" placeholder="dd-mm-yyyy" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea rows="3" class="form-control" id="description" name="description" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="expired_in" class="form-label">Akan Habis (Hari)</label>
                                <input type="text" class="form-control" id="expired_in" name="expired_in" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail'));
        let expiration = parseInt('{{ \App\Helper\Formula::ExpirationLimit }}');
        let grantedUpdate = '{{ $access['is_granted_update'] }}';
        let grantedDelete = '{{ $access['is_granted_delete'] }}';

        function deleteEvent() {
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menghapus data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        destroy(id);
                    }
                });

            })
        }

        function destroy(id) {
            let url = path + '/' + id + '/delete';
            AjaxPost(url, {}, function() {
                SuccessAlert('Success', 'Berhasil Menghapus Data...').then(() => {
                    table.ajax.reload();
                });
            });
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                detailHandler(id);
            });
        }

        async function detailHandler(id) {
            try {
                let url = path + '/' + id + '/detail';
                let response = await $.get(url);
                let data = response['data'];
                let area = data['area']['name'];
                let name = data['name'];
                let birth_place = data['birth_place'];
                let date_of_birth = data['date_of_birth'];
                let identity_number = data['identity_number'];
                let certification_unit = data['certification_unit'];
                let certification_number = data['certification_number'];
                let expired_date = data['expired_date'];
                let description = data['description'];
                let expiredIn = data['expired_in'];
                let status = data['status'] === 'valid' ? 'BERLAKU' : 'HABIS MASA BERLAKU';
                $('#area').val(area);
                $('#human-name').val(name);
                $('#birth_place').val(birth_place);
                $('#date_of_birth').val(date_of_birth);
                $('#identity_number').val(identity_number);
                $('#certification_unit').val(certification_unit);
                $('#certification_number').val(certification_number);
                $('#expired_date').val(expired_date);
                $('#expired_in').val(expiredIn);
                $('#status').val(status);
                $('#description').val(description);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }

        function generateTableData() {
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                responsive: true,
                processing: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function(d) {
                        d.area = $('#area-option').val();
                        d.name = $('#name').val();
                        d.status = $('#status-option').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center'
                        // width: '30px'
                    },
                    {
                        data: 'area.name',
                        name: 'area.name',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'identity_number',
                        name: 'identity_number',
                        className: 'text-center'
                    },
                    {
                        data: 'certification_unit',
                        name: 'certification_unit',
                        className: 'text-center'
                    },
                    {
                        data: 'certification_number',
                        name: 'certification_number',
                        className: 'text-center'
                    },
                    {
                        data: 'expired_date',
                        name: 'expired_date',
                        render: function(data) {
                            const v = new Date(data);
                            return v.toLocaleDateString('id-ID', {
                                month: '2-digit',
                                year: 'numeric',
                                day: '2-digit'
                            }).split('/').join('-')
                        },
                        className: 'text-center',
                    },
                    {
                        data: 'expired_in',
                        name: 'expired_in',
                        render: function(data) {
                            return data;
                        },
                        className: 'text-center',
                        // width: '80px',
                    },
                    {
                        data: null,
                        render: function(data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            let elEdit = grantedUpdate === '1' ? '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' : '';
                            let elDelete = grantedDelete === '1' ?
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data[
                                    'id'] + '">Delete</a>' : '';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' +
                                data['id'] + '">Detail</a>' + elEdit + elDelete;
                        },
                        orderable: false,
                        className: 'text-center',
                    }
                ],
                columnDefs: [{
                    targets: '_all',
                    className: 'middle-header'
                }],
                paging: true,
                "fnDrawCallback": function(setting) {
                    deleteEvent();
                    eventOpenDetail();
                },
                dom: 'ltrip',
                createdRow: function(row, data, index) {
                    if (data['expired_in'] < expiration) {
                        $('td', row).css({
                            'background-color': '#fecba1'
                        });
                    }
                },
            });
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            generateTableData();
            $('#btn-search').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-export').on('click', function(e) {
                e.preventDefault();
                let area = $('#area-option').val();
                let name = $('#name').val();
                let status = $('#status-option').val();
                let queryParam = '?area=' + area + '&name=' + name + '&status=' + status;
                let exportPath = path + '/excel' + queryParam;
                window.open(exportPath, '_blank');
            });
        });
    </script>
@endsection
