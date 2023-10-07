@extends('admin.base')

@section('title')
    Tambah Project Yousee
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <style>
        .select2-selection__rendered {
            line-height: 36px !important;
        }

        .select2-container .select2-selection--single {
            height: 36px !important;
            border: 1px solid #ddd;
        }

        .select2-selection__arrow {
            height: 36px !important;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin/project">Project</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Project</li>
        </ol>
    </nav>

    <div>
        <div class="row">
            <div class="col-4">
                <div class="panel p-4">
                    <form id="formProject" onsubmit="return saveForm()">
                        @csrf
                        <input id="id" name="id" value="{{ request('q') }}" hidden>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_nama" name="name" required
                                value="{{ $data ? $data->name : '' }}" placeholder="Nama Project">
                            <label for="inp_nama" class="form-label">Nama Project</label>
                        </div>

                        <div class="form-floating mb-3 nput-group date datepicker" id="datepicker"
                            data-provide="datepicker">
                            <input type="text" class="form-control" id="date" name="request_date" required
                                onchange="changeDate(this)"
                                value="{{ $data ? date('d/m/Y', strtotime($data->request_date)) : '' }}"
                                placeholder="Tanggal Request">
                            <label for="date" class="form-label">Tanggal Request</label>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-stretch mb-3 ">
                            <div class="form-floating me-1">
                                <input type="text" class="form-control" id="inp_durasi" name="duration" required
                                    value="{{ $data ? $data->duration : '' }}" placeholder="Nama Tipe">
                                <label for="inp_durasi" class="form-label">Durasi</label>
                            </div>
                            <select class="form-select" aria-label="Default select example" id="duration_unit"
                                name="duration_unit">
                                <option selected>Pilih Durasi</option>
                                <option value="day">Hari</option>
                                <option value="week">Minggu</option>
                                <option value="week">Bulan</option>
                                <option value="year">Tahun</option>
                            </select>
                        </div>

                        {{-- <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_budget" name="inp_budget" required
                                   placeholder="Nama Tipe">
                            <label for="inp_budget" class="form-label">Budget</label>
                        </div> --}}

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inp_pic_client" name="client_pic" required
                                value="{{ $data ? $data->client_pic : '' }}" placeholder="Nama PIC">
                            <label for="inp_budget" class="form-label">PIC Client</label>
                        </div>


                        <div class="form-floating mb-3 ">
                            <textarea style="height: auto;" type="text" class="form-control" id="name" name="description" rows="10"
                                required placeholder="Nama Tipe">{{ $data ? $data->description : '' }}</textarea>
                            <label for="name" class="form-label">Keterangan</label>
                        </div>

                        <div class="my-3">
                            <div class="d-flex">
                                <button type="submit" class="btn-utama" style="width: 100%">
                                    @if (request('q'))
                                        Edit
                                    @else
                                        Simpan
                                    @endif
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="panel mb-1">
                    <div class="title">
                        <p>Data Titik</p>
                        @if (request('q'))
                            <div class="d-flex">
                                <a class="btn-success-soft sml rnd me-2" id="addPic">Tambah PIC titik<i
                                        class="material-symbols-outlined menu-icon ms-2 text-success">add_circle</i></a>

                                <a class="btn-utama-soft sml rnd " id="addDataTitik">Tambah Titik <i
                                        class="material-symbols-outlined menu-icon ms-2 text-grey">arrow_right_alt</i></a>
                            </div>
                        @endif
                    </div>
                    <div class="isi">
                        <div class="table">
                            <table id="tbDetail" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kota</th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Kota</th>
                                        <th>Lokasi titik</th>
                                        <th>PIC /titik</th>
                                        <th>Harga Vendor</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                @if (request('q'))
                    <div class="panel p-4">
                        <div class="d-flex flex-column">
                            <div class="d-flex">
                                <span class="material-symbols-outlined menu-icon me-2">info</span>
                                <div>
                                    <div id="countCity">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mt-2">
                                <span class="material-symbols-outlined menu-icon me-2">info</span>
                                <div>
                                    <div id="countPic">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif
            </div>

        </div>
        <!-- Modal Tambah Titik-->
        <div class="modal fade" id="modaltambahtitik" tabindex="-1" aria-labelledby="modaltambahtitik"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah Titik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-8">
                                <div class="table">
                                    <table id="tambahtitik" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kota</th>
                                                <th>Alamat</th>
                                                <th>Lokasi</th>
                                                <th>Vendor</th>
                                                <th>Lebar</th>
                                                <th>Tinggi</th>
                                                <th>Type</th>
                                                <th>Posisi</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Kota</th>
                                                <th>Alamat</th>
                                                <th>Lokasi</th>
                                                <th>Vendor</th>
                                                <th>Lebar</th>
                                                <th>Tinggi</th>
                                                <th>Type</th>
                                                <th>Posisi</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="panel p-4">

                                    <form id="formTitik" onsubmit="return saveTitik()">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <input id="id" name="id" hidden>
                                                <input id="idTitik" name="item_id" hidden>
                                                <input id="city_id" name="city_id" hidden>
                                                <input id="idTitik" name="action" value="titik" hidden>

                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="kota"
                                                        name="kota" placeholder="Kota" readonly>
                                                    <label for="kota" class="form-label">Kota</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="alamat"
                                                        name="alamat" placeholder="Alamat" readonly>
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="tinggi"
                                                        name="tinggi" placeholder="Tinggi" readonly>
                                                    <label for="tinggi" class="form-label">Tinggi</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="lebar"
                                                        name="lebar" placeholder="Lebar" readonly>
                                                    <label for="lebar" class="form-label">Lebar</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="tipe"
                                                        name="tipe" placeholder="tipe" readonly>
                                                    <label for="tipe" class="form-label">Tipe</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="nama_vendor"
                                                        name="nama_vendor" placeholder="nama_vendor" readonly>
                                                    <label for="nama_vendor" class="form-label">Nama Vendor</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class=" mb-3">
                                                    <input id="idPic" name="idPic" hidden>
                                                    {{--                                            <input type="text" class="form-control" id="inp_namapic" --}}
                                                    {{--                                                   name="inp_namapic" required placeholder="Nama PIC"> --}}
                                                    <label for="inp_namapic" class="form-label">Nama PIC</label>
                                                    <select id="inp_namapic" required name="pic_id" class="form-select "
                                                        style="width: 100%" aria-label="Default select example">
                                                    </select>
                                                </div>

                                                <div class="mb-3 ">
                                                    <label for="inp_berlampu" class="form-label">Berlampu</label>
                                                    <div class="d-flex">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_lighted" value="1" id="inp_berlampu_ya">
                                                            <label class="form-check-label" for="inp_berlampu_ya">
                                                                Ya
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="is_lighted" value="0" id="inp_berlampu_tidak"
                                                                checked>
                                                            <label class="form-check-label" for="inp_berlampu_tidak">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="statAvail"
                                                        value="Tersedia" id="checkAvail" onchange="changeAvail()">
                                                    <label class="form-check-label" for="checkAvail">
                                                        Tersedia
                                                    </label>
                                                </div>
                                                <div class="form-floating mb-3 input-group date datepicker"
                                                    id="tanggaltersedia" data-provide="datepicker">

                                                    <input type="text" class="form-control" id="date"
                                                        onchange="changeData(this)" name="dateAvail" required
                                                        value="" placeholder="Tersedia Tanggal">
                                                    <label for="date" class="form-label">Tersedia Tanggal</label>
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>

                                                <div class="form-floating mb-3">
                                                    <input type="text" pattern="[0-9,]+" class="form-control" id="inp_hargavendor" oninvalid="this.setCustomValidity('Harga tidak sesuai')" onchange="this.setCustomValidity('')"
                                                        name="vendor_price" required placeholder="Harga Vendor">
                                                    <label for="inp_hargavendor" class="form-label">Harga dari
                                                        Vendor</label>
                                                </div>

                                                {{--                                                <div class="panel p-2 bg-primary-grey"> --}}
                                                {{--                                                    <p>Harga Dari Vendor <span class="unset text-primary">(Optional)</span> --}}
                                                {{--                                                    </p> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga1" --}}
                                                {{--                                                               name="inp_harga1" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga1" class="form-label">Harga 1 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga3" --}}
                                                {{--                                                               name="inp_harga3" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga3" class="form-label">Harga 3 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga6" --}}
                                                {{--                                                               name="inp_harga6" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga6" class="form-label">Harga 6 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                    <div class="form-floating mb-3"> --}}
                                                {{--                                                        <input type="number" class="form-control" id="inp_harga12" --}}
                                                {{--                                                               name="inp_harga12" placeholder="Harga Vendor"> --}}
                                                {{--                                                        <label for="inp_harga12" class="form-label">Harga 12 --}}
                                                {{--                                                            Bulan</label> --}}
                                                {{--                                                    </div> --}}
                                                {{--                                                </div> --}}
                                            </div>
                                        </div>

                                        <div class="my-3">
                                            <div class="d-flex">
                                                <button type="submit" class="btn-utama" style="width: 100%">Simpan
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal PIC Titik -->
        <div class="modal fade" id="modaltambahpictitik" tabindex="-1" aria-labelledby="modaltambahpictitik"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modaltambahuser">Tambah PIC Titik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="panel p-4">
                            <form id="formPIC" onsubmit="return saveFormPIC()">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="in_kota" class="form-label">Pilih Provinsi</label>
                                    <select id="province" required name="province" class="form-select "
                                        style="width: 100%" aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="city" class="form-label">Pilih Kota</label>
                                    <select id="city" required name="city_id" class="form-select "
                                        style="width: 100%" aria-label="Default select example">
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="pic_id" class="form-label">Nama PIC</label>
                                    <select id="pic_id" required name="pic_id" class="form-select "
                                        style="width: 100%" aria-label="Default select example">
                                    </select>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="in_jumlah" name="qtyPic" required
                                        placeholder="Jumlah">
                                    <label for="in_jumlah" class="form-label">Jumlah</label>
                                </div>

                                <div class="my-3">
                                    <div class="d-flex">
                                        <button type="submit" class="btn-utama" style="width: 100%">Simpan</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('morejs')
    <script src="{{ asset('js/number_formater.js') }}"></script>
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/currency.js') }}"></script>

    <script>
        let param, prov, pic_id;
        var urlTitik = "/data/item/datatable";
        let idProject = ''

        $(document).ready(function() {
            param = '{{ request('q') }}'
            $('#duration_unit').val('{{ $data ? $data->duration_unit : '' }}')
            $('#project_id').val(param)
            $('#inp_berlampu_ya').prop('checked', '{{ $data && $data->is_lighted == 1 ? true : false }}')
            $('#inp_berlampu_tidak').prop('checked', '{{ $data && $data->is_lighted == 0 ? true : false }}')
            // $('#tambahtitik').DataTable();
            currency('inp_hargavendor');

            $('#titik').DataTable();
            console.log('asdas', param)
            $('#province').select2({
                dropdownParent: $("#modaltambahpictitik")
            });
            $('#city').select2({
                dropdownParent: $("#modaltambahpictitik")
            });
            $('#pic_id').select2({
                dropdownParent: $("#modaltambahpictitik")
            });
            $('#inp_namapic').select2({
                dropdownParent: $("#modaltambahtitik")
            });
            showTable()
            showDatatableItem()
            idProject = '{{ request('q') }}'
            getCountCity()
            getCountPIC()
        });

        function changeDate(a) {
            console.log($(a).val())
        }

        $(document).on('click', '#addPic', function() {
            console.log('asdasd')
            getSelect("province", "/data/province", "name", prov, "Pilih Provinsi");
            getSelect("pic_id", "{{ route('user.get.json') }}", "nama", pic_id, "Pilih PIC");
            $('#modaltambahpictitik #city').empty().trigger('change')
            $('#modaltambahpictitik #in_jumlah').val('1')
            $('#modaltambahpictitik').modal('show')
        })

        function getCountCity() {
            let divCity = $('#countCity')
            divCity.empty()
            let url = '{{ route('tambahproject.count.city', ['id' => 'vallll']) }}'
            url = url.split('vallll').join(idProject)
            $.get(url, function(req) {
                $.each(req, function(k, v) {
                    divCity.append('<div>' +
                        '<label>' + v.name + ' : ' + v.count + '</label>' +
                        '</div>')
                })
            })
        }

        function getCountPIC() {
            let divCity = $('#countPic')
            divCity.empty()
            let url = '{{ route('tambahproject.count.pic', ['id' => 'vallll']) }}'
            url = url.split('vallll').join(idProject)
            $.get(url, function(req) {
                $.each(req, function(k, v) {
                    divCity.append('<div>' +
                        '<label>' + v.nama + ' : ' + v.count + '</label>' +
                        '</div>')
                })
            })
        }

        function changeAvail() {
            let check = $('#checkAvail').prop('checked');
            $('#modaltambahtitik #date').val('');
            if (check) {
                $('#modaltambahtitik #date').attr('disabled', '')
            } else {
                $('#modaltambahtitik #date').removeAttr('disabled')
            }
        }

        $(function() {
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: 'TRUE',
                autoclose: true,
            });
        });

        $(document).on("change", "#province", function() {
            let id = $(this).val();
            getSelect(
                "city",
                "/data/province/" + id + "/city",
                "name",
                null,
                "Pilih Kota"
            );
        });

        function showTable() {
            let column = [{
                    "className": '',
                    "orderable": false,
                    "defaultContent": ''
                },
                {
                    "data": "city.name",
                    "name": "city.name"
                },
                {
                    "data": "item.location",
                    "name": "item.location"
                },
                {
                    "data": "pic.nama",
                    "name": "pic.nama"
                },
                {
                    "data": "vendor_price",
                    "name": "vendor_price",
                    "render": function (data) {
                        return 'Rp. '+data.toLocaleString()
                    }
                },
                {
                    "data": "id",
                    searchable: false,
                    "render": function(data, type, row) {
                        console.log(row)
                        return "<div class='d-flex gap-2'>\n" +
                            // "                                <a class='btn-success-soft sml rnd' data-id='" +
                            // data + "'  id='editData'> <i class='material-symbols-outlined menu-icon'>edit</i></a>" +
                            "                               " +
                            " <a class='btn-success-soft sml rnd' data-itemid='" + row?.item_id + "' data-tipe='" +
                            row?.item?.type?.name + "' data-tinggi='" + row?.item?.height + "' data-lebar='" + row
                            ?.item?.width + "' data-lokasi='" + row?.item?.location + "' data-kotaid='" + row.city_id + "' data-kota='" + row?.city?.name + "' data-picnama='" + row?.pic
                            ?.nama + "' data-pic_id='" + row.pic_id + "' data-harga='" + row?.vendor_price +
                            "' data-available='" + row?.available + "' data-light='" + row?.is_lighted +
                            "' data-id='" + data +
                            "'  id='mapData'> <i class='material-symbols-outlined menu-icon'>map</i></a>" +
                            " <a class='btn-danger sml rnd  me-1' data-id='" + data +
                            "' role='button' id='deleteTitik'> <i" +
                            "    class='material-symbols-outlined menu-icon text-white'>delete</i></a>" +
                            "</div>";
                    }
                },
            ]
            datatable('tbDetail', '{{ route('tambahproject.datatable', ['q' => request('q')]) }}', column)
        }

        $(document).on('click', '#deleteTitik', function() {
            let id = $(this).data('id');
            let data = {
                _token: '{{ csrf_token() }}',
            };
            deleteData(name, "/admin/project/addproject/delete/" + id, data, afterSaveTitik);
        })

        function showDatatableItem() {
            let column = [{
                "className": '',
                "orderable": false,
                "defaultContent": ''
            }, {
                "data": "city.name",
                "name": "city.name"
            }, {
                "data": "address",
                "name": "address"
            },{
                "data": "location",
                "name": "location"
            }, {
                "data": "vendor_all.name",
                "name": "vendorAll.name"
            }, {
                "data": "width",
                "name": "width"
            }, {
                "data": "height",
                "name": "height"
            }, {
                "data": "type.name",
                "name": "type.name"
            }, {
                "data": "position",
                "name": "position"
            }, {
                "data": "id",
                searchable: false,
                "render": function(data, type, row) {
                    return "<div class='d-flex gap-2'>" +
                        "<a data-id='" + row.id + "' data-vendor='" + row.vendor_all.name + "' data-kotaid='" +
                        row?.city_id + "' data-kota='" + row
                        ?.city?.name + "' data-type='" + row?.type?.name + "' data-width='" + row.width +
                        "' data-height='" + row.height + "' data-location='" + row.location +
                        "' class='btn-utama sml rnd  me-1'" +
                        "  id='addItem'> <i class='material-symbols-outlined menu-icon text-white'>arrow_right_alt</i></a>\n" +
                        "</div>"
                }
            }, ]
            datatable('tambahtitik', urlTitik, column)

        }

        $(document).on('click', '#addItem', function() {
            let row = $(this).data()
            console.log('asdadas', row)
            $('#idTitik').val(row.id);
            $('#city_id').val(row.kotaid);
            $('#kota').val(row.kota);
            $('#alamat').val(row.location);
            $('#tinggi').val(row.height);
            $('#lebar').val(row.width);
            $('#tipe').val(row.type);
            $('#nama_vendor').val(row.vendor);
        })

        function changeData(a) {
            console.log('asdasd', $(a).val())
        }

        $(document).on('click', '#mapData, #addDataTitik', function() {
            let row = $(this).data()
            console.log('asd', row)
            // $('#inp_namapic').val(row?.picnama)
            $('#formTitik #id').val(row?.id)
            $('#idPic').val(row?.pic_id)

            $('#idTitik').val(row?.itemid);
            $('#city_id').val(row?.kotaid);
            $('#kota').val(row?.kota);
            $('#alamat').val(row?.lokasi);
            $('#tinggi').val(row?.tinggi == "undefined" ? '' : row?.tinggi);
            $('#lebar').val(row?.lebar == "undefined" ? '' : row?.tinggi);
            $('#tipe').val(row?.tipe == "undefined" ? '' : row?.tipe);
            $('#inp_hargavendor').val(row?.harga);
            $("input[name=is_lighted][value='" + row.light + "']").prop("checked", true);
            let avail = row?.available
            $('#checkAvail').prop("checked", false);
            if (avail == "Tersedia") {
                $('#checkAvail').prop("checked", true);
                changeAvail()
            } else {
                changeAvail()
                $('#modaltambahtitik #date').val(avail)
            }
            getSelect("inp_namapic", "{{ route('user.get.json') }}", "nama", row?.pic_id, "Pilih PIC");
            let url = urlTitik;
            if (row?.kotaid){
                url = url+'?city='+row?.kotaid;
            }
            $('#tambahtitik').DataTable().ajax.url(url).load()

            $('#modaltambahtitik').modal('show')
        })

        function saveForm() {
            saveDataObjectFormData(
                "Simpan Data",
                $('#formProject').serialize(),
                "{{ route('project') }}"
            );
            return false;
        }

        function saveFormPIC() {
            saveDataObjectFormData(
                "Simpan Data PIC",
                $('#formPIC').serialize(),
                "{{ route('tambahproject', ['q' => request('q')]) }}", afterSaveTitik
            );
            return false;
        }

        function saveTitik() {
            saveDataObjectFormData(
                "Simpan Data Titik",
                $('#formTitik').serialize(),
                "{{ route('tambahproject', ['q' => request('q')]) }}", afterSaveTitik
            );
            return false;
        }

        function afterSaveTitik() {
            $('#modaltambahtitik').modal('hide')
            $('#modaltambahpictitik').modal('hide')
            $('#tbDetail').DataTable().ajax.reload()
            getCountCity()
            getCountPIC()
        }
    </script>
@endsection
