@extends('admin/base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">PERISTIWA LUAR BIASA HEBAT (PLH) {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Peristiwa Luar Biasa Hebat (PLH) {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Peristiwa Luar Biasa Hebat (PLH) {{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="area-option" class="form-label d-none">Wilayah (Daerah Operasi)</label>
                            <select class="select2 form-control" name="area-option" id="area-option"
                                    style="width: 100%;">
                                <option value="">Semua DAOP</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <a id="btn-search" class="btn-utama sml rnd ms-2" href="#" style="padding: 0.6rem 1.25rem">Cari</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="title">
            <p>Data Peristiwa Luar Biasa Hebat (PLH) {{ $service_unit->name }}</p>
            <div class="d-flex align-item-center">
                <a class="btn-utama sml rnd me-2"
                   href="{{ route('means.direct-passage-accident.service-unit.add', ['service_unit_id' => $service_unit->id]) }}">Tambah
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                </a>
                <a class="btn-success sml rnd" href="#" id="btn-export"
                   target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                <tr>
                    <th class="text-center middle-header" width="5%" rowspan="2">#</th>
                    <th class="text-center middle-header" width="8%" rowspan="2">Wilayah</th>
                    <th class="text-center middle-header" width="8%" rowspan="2">JPL</th>
                    <th class="text-center middle-header" width="8%" rowspan="2">Waktu</th>
                    <th class="middle-header" rowspan="2">Jenis Kereta Api</th>
                    <th class="text-center middle-header" width="15%" rowspan="2">Jenis Laka</th>
                    <th class="text-center middle-header" colspan="3">Korban Jiwa</th>
                    <th class="text-center middle-header" width="15%" rowspan="2">Aksi</th>
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
    <div class="modal fade" id="modal-detail-certification" tabindex="-1" aria-labelledby="modal-detail-certification"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Peristiwa Luar Biasa Hebat (PLH)
                        Bencana</p>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="area" class="form-label">Wilayah (Daerah Operasi)</label>
                                <input type="text" class="form-control" name="area" id="area" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="track" class="form-label">Perlintasan</label>
                                <input type="text" class="form-control" name="track" id="track" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="sub_track" class="form-label">Petak</label>
                                <input type="text" class="form-control" name="sub_track" id="sub_track" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="name" class="form-label">JPL</label>
                                <input type="text" class="form-control" name="name" id="name" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="stakes" class="form-label">KM</label>
                                <input type="text" class="form-control" id="stakes"
                                       name="stakes"
                                       placeholder="KM" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="train_name" class="form-label">Jenis Kereta Api</label>
                                <input type="text" class="form-control" name="train_name" id="train_name" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="accident_type" class="form-label">Jenis Laka</label>
                                <input type="text" class="form-control" name="accident_type" id="accident_type"
                                       disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="injured" class="form-label">Korban Luka-Luka</label>
                                <input type="number" class="form-control" id="injured" name="injured" value="0" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="died" class="form-label">Korban Meninggal</label>
                                <input type="number" class="form-control" id="died" name="died" value="0" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="damaged_description" class="form-label">Kerugian</label>
                                <textarea rows="3" class="form-control" id="damaged_description" name="damaged_description" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="description" class="form-label">Keterangan/Tindak Lanjut</label>
                                <textarea rows="3" class="form-control" id="description" name="description" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';

        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));


        function deleteEvent() {
            $('.btn-delete').on('click', function (e) {
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
            AjaxPost(url, {}, function () {
                SuccessAlert('Success', 'Berhasil Menghapus Data...').then(() => {
                    table.ajax.reload();
                    generateMapDisasterArea();
                });
            });
        }

        function eventOpenDetail() {
            $('.btn-detail').on('click', function (e) {
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
                let area = data['direct_passage']['sub_track']['track']['area']['name'];
                let track = data['direct_passage']['sub_track']['track']['code'];
                let subTrack = data['direct_passage']['sub_track']['code'];
                let name = data['direct_passage']['name'];
                let stakes = data['direct_passage']['stakes'];
                let train_name = data['train_name'];
                let accident_type = data['accident_type'];
                let injured = data['injured'];
                let died = data['died'];
                let damaged_description = data['damaged_description'];
                let description = data['description'];

                $('#area').val(area);
                $('#track').val(track);
                $('#sub_track').val(subTrack);
                $('#name').val(name);
                $('#stakes').val(stakes);
                $('#train_name').val(train_name);
                $('#accident_type').val(accident_type);
                $('#injured').val(injured);
                $('#died').val(died);
                $('#damaged_description').val(damaged_description);
                $('#description').val(description);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }


        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            table = $('#table-data').DataTable({
                "aaSorting": [],
                "order": [],
                scrollX: true,
                processing: true,
                responsive: true,
                ajax: {
                    type: 'GET',
                    url: path,
                    'data': function (d) {
                        d.area = $('#area-option').val();
                    }
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                    className: 'text-center middle-header',
                },
                    {
                        data: 'direct_passage.sub_track.track.area.name',
                        name: 'direct_passage.sub_track.track.area.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'direct_passage.name',
                        name: 'direct_passage.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: null,
                        name: null,
                        className: 'text-center middle-header',
                        render: function (data) {
                            let result = '';
                            if (data['date'] !== null) {
                                let dateVal = new Date(data['date']);
                                return dateVal.toLocaleDateString('id-ID', {
                                    month: '2-digit',
                                    year: 'numeric',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute:'2-digit'
                                }).split('/').join('-')
                            }
                            return result
                        }
                    },
                    {
                        data: 'train_name',
                        name: 'train_name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'accident_type',
                        name: 'accident_type',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'injured',
                        name: 'injured',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'died',
                        name: 'died',
                        className: 'text-center middle-header',
                    },
                    {
                        data: null,
                        name: null,
                        className: 'text-center middle-header',
                        render: function (data) {
                            return parseInt(data['injured']) + parseInt(data['died'])
                        }
                    },

                    {
                        data: null,
                        render: function (data) {
                            let urlEdit = path + '/' + data['id'] + '/edit';
                            return '<a href="#" class="btn-detail me-2 btn-table-action" data-id="' + data[
                                    'id'] + '">Detail</a>' +
                                '<a href="' + urlEdit +
                                '" class="btn-edit me-2 btn-table-action" data-id="' + data['id'] +
                                '">Edit</a>' +
                                '<a href="#" class="btn-delete btn-table-action" data-id="' + data['id'] +
                                '">Delete</a>';
                        },
                        orderable: false,
                        className: 'text-center middle-header',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function (setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
                dom: 'ltrip'
            });

            $('#btn-search').on('click', function (e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-export').on('click', function (e) {
                e.preventDefault();
                let serviceUnit = $('#service-unit-option').val();
                let resort = $('#resort-option').val();
                let locationType = $('#location-type-option').val();
                let queryParam = '?service_unit=' + serviceUnit + '&resort=' + resort + '&location_type=' + locationType;
                // window.open(exportPath, '_blank');
            });
        })
    </script>
@endsection
