@extends('admin.base')

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Ooops", 'internal server error...', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('validator'))
        <script>
            Swal.fire("Ooops", '{{ \Illuminate\Support\Facades\Session::get('validator') }}', "error")
        </script>
    @endif
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire({
                title: 'Success',
                text: 'Berhasil Merubah Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href =
                    '{{ route('means.human-resource.main', ['service_unit_id' => $service_unit->id, 'slug' => $slug]) }}';
            })
        </script>
    @endif

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SDM {{ $type }} {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data SDM {{ $type }} {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('means.human-resource.main', ['service_unit_id' => $service_unit->id, 'slug' => $slug]) }}">SDM
                        {{ $type }} {{ $service_unit->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Edit Data SDM {{ $type }}</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah (Daerah Operasi) <span
                                    class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ $data->area_id === $area->id ? 'selected' : '' }}>{{ $area->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('area'))
                                <div class="text-danger">
                                    {{ $errors->first('area') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="name" class="form-label">Nama <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $data->name }}" placeholder="Nama Lengkap">
                            @if ($errors->has('name'))
                                <div class="text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="birth_place" class="form-label">Tempat Lahir <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="birth_place" name="birth_place"
                                value="{{ $data->birth_place }}" placeholder="Tempat Lahir">
                            @if ($errors->has('birth_place'))
                                <div class="text-danger">
                                    {{ $errors->first('birth_place') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="date_of_birth" name="date_of_birth"
                                placeholder="dd-mm-yyyy">
                            @if ($errors->has('date_of_birth'))
                                <div class="text-danger">
                                    {{ $errors->first('date_of_birth') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="identity_number" class="form-label">No. Identitas <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="identity_number" name="identity_number"
                                value="{{ $data->identity_number }}" placeholder="Nomor Identitas">
                            @if ($errors->has('identity_number'))
                                <div class="text-danger">
                                    {{ $errors->first('identity_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="certification_unit" class="form-label">Unit Pengajuan Sertifikasi <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="certification_unit" name="certification_unit"
                                value="{{ $data->certification_unit }}" placeholder="Unit Pengajuan Sertifikasi">
                            @if ($errors->has('certification_unit'))
                                <div class="text-danger">
                                    {{ $errors->first('certification_unit') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="certification_number" class="form-label">Kodefikasi Sertifikat <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="certification_number" name="certification_number"
                                placeholder="kodefikasi sertifikat" value="{{ $data->certification_number }}">
                            @if ($errors->has('certification_number'))
                                <div class="text-danger">
                                    {{ $errors->first('certification_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="expired_date" class="form-label">Tanggal Habis Berlaku <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control datepicker" id="expired_date" name="expired_date"
                                placeholder="dd-mm-yyyy">
                            @if ($errors->has('expired_date'))
                                <div class="text-danger">
                                    {{ $errors->first('expired_date') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" id="description" name="description">{{ $data->description }}</textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a class="btn-utama rnd" id="btn-save" href="#">Simpan
                        <i class="material-symbols-outlined menu-icon ms-1 text-white">save</i>
                    </a>
                </div>
            </div>
        </div>
    </form>
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
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';

        function initializeDate() {
            let birthDateValue = '{{ $data->date_of_birth }}';
            let expiredDateValue = '{{ $data->expired_date }}';
            let birthDate = new Date(birthDateValue);
            let expiredDate = new Date(expiredDateValue);
            $('#date_of_birth').datepicker('setDate', birthDate);
            $('#expired_date').datepicker('setDate', expiredDate);
        }

        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
            });
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
            });

            initializeDate();
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
