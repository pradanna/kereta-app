@extends('admin/base')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", 'internal server error...', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: 'Berhasil Menambahkan Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('facility-certification-train-diesel') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SERTIFIKASI SARANA KERETA REL DIESEL</h1>
            <p class="mb-0">Manajemen Tambah Data Sertifikasi Sarana Kereta Rel Diesel (KRD)</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('facility-certification-train-diesel') }}">Sertifikasi Sarana
                        Kereta Diesel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Form Sertifikasi Sarana Kereta Diesel</p>
        </div>
        <div class="isi">
            <form method="post" id="form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="train_type" class="form-label">Jenis Kereta</label>
                            <select class="select2 form-control" name="train_type" id="train_type" style="width: 100%;">
                                @foreach ($train_types as $train_type)
                                    <option value="{{ $train_type->id }}">{{ $train_type->code }} ({{ $train_type->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah</label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="storehouse" class="form-label">Depo Induk</label>
                            <select class="select2 form-control" name="storehouse" id="storehouse" style="width: 100%;">
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="ownership" class="form-label">Kepemilikan</label>
                            <input type="text" class="form-control" id="ownership" name="ownership"
                                placeholder="Contoh: PT. KAI">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="facility_number" class="form-label">No. Sarana</label>
                            <input type="text" class="form-control" id="facility_number" name="facility_number"
                                placeholder="Nomor Sarana">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="testing_number" class="form-label">No. BA Pengujian</label>
                            <input type="text" class="form-control" id="testing_number" name="testing_number"
                                placeholder="Nomor BA Pengujian">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_start_date" class="form-label">Mulai Dinas</label>
                            <input type="text" class="form-control datepicker" id="service_start_date"
                                name="service_start_date" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="service_expired_date" class="form-label">Masa Berlaku</label>
                            <input type="text" class="form-control datepicker" id="service_expired_date"
                                name="service_expired_date" placeholder="dd-mm-yyyy">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama  rnd " id="btn-save" href="#">Simpan <i
                            class="material-symbols-outlined menu-icon ms-2 text-white">save</i></a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('select2/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let areaPath = '{{ route('area') }}';

        function getStorehouseByAreaID() {
            let areaID = $('#area').val();
            let type = 2;
            let url = areaPath + '/' + areaID + '/storehouse?type=' + type;
            return $.get(url);
        }

        function generateStorehouseOption() {
            let elOption = $('#storehouse');
            elOption.empty();
            getStorehouseByAreaID().then((response) => {
                let data = response.data;
                $.each(data, function(k, v) {
                    elOption.append('<option value="' + v['id'] + '">' + v['name'] + ' (' + v[
                        'storehouse_type']['name'] + ')</option>')
                });
                $('#storehouse').select2({
                    width: 'resolve',
                });
                console.log(response);
            }).catch((error) => {
                console.log(error)
            })
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
            });
            generateStorehouseOption();
            $('#area').on('change', function(e) {
                generateStorehouseOption();
            });

            $('#btn-save').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Konfirmasi!",
                    text: "Apakah anda yakin menyimpan data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.value) {
                        $('#form-data').submit()
                    }
                });
            });

        });
    </script>
@endsection
