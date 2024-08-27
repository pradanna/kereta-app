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
                <li class="breadcrumb-item active" aria-current="page">Peristiwa Luar Biasa Hebat
                    (PLH) {{ $service_unit->name }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel w-100 shadow-sm mb-3">
        <div class="isi">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 row gx-2">
                    <div class="col-4">
                        <div class="form-group w-100">
                            <label for="area-option" class="form-label d-none">Wilayah (Daerah Operasi)</label>
                            <select class="select2 form-control" name="area-option" id="area-option" style="width: 100%;">
                                <option value="">Semua DAOP</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group w-100">
                            <label for="date" class="form-label d-none">Tanggal Kejadian <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="date" name="date"
                                placeholder="Periode Tahun" value="">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group w-100">
                            <label for="direct-passage-option" class="form-label d-none">No. JPL</label>
                            <select class="select2 form-control" name="direct-passage-option" id="direct-passage-option"
                                style="width: 100%;">
                                <option value="none">Semua JPL dan Semua yang tidak berada pada JPL</option>
                                <option value="">Tidak Berada Pada Jalur Perlintasan Langsung</option>
                                @foreach ($direct_passages as $direct_passage)
                                    <option value="{{ $direct_passage->id }}">{{ $direct_passage->name }}</option>
                                @endforeach
                            </select>
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
    <div class="panel">
        <div class="title">
            <p>Data Peristiwa Luar Biasa Hebat (PLH) {{ $service_unit->name }}</p>
            <div class="d-flex align-item-center">
                @if ($access['is_granted_create'])
                    <a class="btn-utama sml rnd me-2"
                        href="{{ route('means.direct-passage-accident.service-unit.add', ['service_unit_id' => $service_unit->id]) }}">Tambah
                        <i class="material-symbols-outlined menu-icon ms-2 text-white">add_circle</i>
                    </a>
                @endif
                <a class="btn-success sml rnd" href="#" id="btn-export" target="_blank">Export
                    <i class="material-symbols-outlined menu-icon ms-2 text-white">file_download</i>
                </a>
            </div>
        </div>
        <div class="isi">
            <table id="table-data" class="display table table-striped w-100">
                <thead>
                    <tr>
                        <th class="text-center middle-header" width="5%">#</th>
                        <th class="text-center middle-header" width="10%">Kota/Kabupaten</th>
                        <th class="text-center middle-header" width="8%">Wilayah</th>
                        <th class="text-center middle-header" width="8%">Lintas</th>
                        <th class="text-center middle-header" width="8%">Petak</th>
                        <th class="text-center middle-header" width="8%">KM/HM</th>
                        <th class="text-center middle-header">Waktu</th>
                        <th class="text-center middle-header" width="10%">JPL</th>
                        {{--                    <th class="middle-header">Jenis Kereta Api</th> --}}
                        {{--                    <th class="text-center middle-header">Jenis Laka</th> --}}
                        <th class="text-center middle-header" width="8%">Korban Jiwa</th>
                        <th class="text-center middle-header" width="8%">Gambar</th>
                        <th class="text-center middle-header" width="15%">Aksi</th>
                    </tr>
                    {{--                <tr> --}}
                    {{--                    <th class="text-center middle-header" width="8%">Luka-Luka</th> --}}
                    {{--                    <th class="text-center middle-header" width="8%">Meninggal</th> --}}
                    {{--                    <th class="text-center middle-header" width="8%">Total</th> --}}
                    {{--                </tr> --}}
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
                    <p style="font-size: 14px; color: #777777; font-weight: bold;">Detail Informasi Peristiwa Luar Biasa
                        Hebat (PLH)
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
                                <label for="track" class="form-label">Lintas</label>
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
                            <div class="w-100">
                                <label for="stakes" class="form-label">KM/HM</label>
                                <input type="text" class="form-control" id="stakes" name="stakes"
                                    placeholder="KM" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="name" class="form-label">No. JPL</label>
                                <input type="text" class="form-control" name="name" id="name" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group w-100">
                                <label for="city" class="form-label">Kota/Kabupaten</label>
                                <input type="text" class="form-control" name="city" id="city" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="time" class="form-label">Waktu Kejadian</label>
                                <input type="text" class="form-control" name="time" id="time" disabled>
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
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="w-100">
                                <label for="injured" class="form-label">Korban Luka-Luka</label>
                                <input type="number" class="form-control" id="injured" name="injured" value="0"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="w-100">
                                <label for="died" class="form-label">Korban Meninggal</label>
                                <input type="number" class="form-control" id="died" name="died" value="0"
                                    disabled>
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
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="w-100">
                                <label for="chronology" class="form-label">Kronologi</label>
                                <textarea rows="3" class="form-control" id="chronology" name="chronology" disabled></textarea>
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        let table;
        let path = '/{{ request()->path() }}';
        var modalDetail = new bootstrap.Modal(document.getElementById('modal-detail-certification'));
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
                    generateMapDisasterArea();
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
                let track = data['track']['code'];
                let subTrack = data['sub_track']['code'];
                let name = data['direct_passage'] !== null ? data['direct_passage']['name'] : '-';
                let stakes = data['stakes'];
                let train_name = data['train_name'];
                let accident_type = data['accident_type'];
                let injured = data['injured'];
                let died = data['died'];
                let damaged_description = data['damaged_description'];
                let description = data['description'];
                let chronology = data['chronology'];
                let latitude = data['latitude'];
                let longitude = data['longitude'];
                let date = data['date'];
                let city = data['city']['name'];

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
                $('#chronology').val(chronology);
                $('#time').val(date);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                $('#city').val(city);
                modalDetail.show();
            } catch (e) {
                alert('internal server error...')
            }
        }


        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'yyyy',
                viewMode: 'years',
                minViewMode: 'years',
                locale: 'id',
                autoclose: true,
                clearBtn: true
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
                    'data': function(d) {
                        d.area = $('#area-option').val();
                        d.date = $('#date').val();
                        d.direct_passage = $('#direct-passage-option').val();
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
                        data: 'city.name',
                        name: 'city.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'area.name',
                        name: 'area.name',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'track.code',
                        name: 'track.code',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'sub_track.code',
                        name: 'sub_track.code',
                        className: 'text-center middle-header',
                    },
                    {
                        data: 'stakes',
                        name: 'stakes',
                        className: 'text-center middle-header',
                    },
                    {
                        data: null,
                        name: null,
                        className: 'text-center middle-header',
                        render: function(data) {
                            let result = '';
                            if (data['date'] !== null) {
                                let dateVal = new Date(data['date']);
                                return dateVal.toLocaleDateString('id-ID', {
                                    month: '2-digit',
                                    year: 'numeric',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                }).split('/').join('-')
                            }
                            return result
                        }
                    },
                    {
                        data: 'direct_passage',
                        name: 'direct_passage',
                        className: 'text-center middle-header',
                        render: function(data) {
                            let value = '-';
                            if (data !== null) {
                                value = data['name'];
                            }
                            return value;
                        }
                    },
                    // {
                    //     data: 'train_name',
                    //     name: 'train_name',
                    //     className: 'text-center middle-header',
                    // },
                    // {
                    //     data: 'accident_type',
                    //     name: 'accident_type',
                    //     className: 'text-center middle-header',
                    // },
                    // {
                    //     data: 'injured',
                    //     name: 'injured',
                    //     className: 'text-center middle-header',
                    // },
                    // {
                    //     data: 'died',
                    //     name: 'died',
                    //     className: 'text-center middle-header',
                    // },
                    {
                        data: null,
                        name: null,
                        className: 'text-center middle-header',
                        render: function(data) {
                            return parseInt(data['injured']) + parseInt(data['died'])
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center middle-header',
                        render: function(data) {
                            let url = path + '/' + data['id'] + '/gambar';
                            return '<a href="' + url +
                                '" class="btn-image btn-table-action">Lihat</a>';
                        }
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
                                data['id'] + '">Detail</a>' + elEdit + elDelete
                        },
                        orderable: false,
                        className: 'text-center middle-header',
                    }
                ],
                columnDefs: [],
                paging: true,
                "fnDrawCallback": function(setting) {
                    eventOpenDetail();
                    deleteEvent();
                },
                dom: 'ltrip'
            });

            $('#btn-search').on('click', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#btn-export').on('click', function(e) {
                e.preventDefault();
                let area = $('#area-option').val();
                let date = $('#date').val();
                let direct_passage = $('#direct-passage-option').val();
                let queryParam = '?area=' + area + '&date=' + date + '&direct_passage=' + direct_passage;
                let exportPath = path + '/excel' + queryParam;
                window.open(exportPath, '_blank');
            });
        })
    </script>
@endsection
