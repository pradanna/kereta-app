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
                    '{{ route('infrastructure.crossing.bridge.main', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">JEMBATAN PENYEBRANGAN {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Tambah Data Jembatan Penyebrangan {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('infrastructure') }}">Prasarana</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('infrastructure.crossing.bridge.main', ['service_unit_id' => $service_unit->id]) }}">Jembatan
                        Penyebrangan {{ $service_unit->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Edit Data Jembatan Penyebrangan</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="area" class="form-label">Wilayah <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="area" id="area" style="width: 100%;">
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}"
                                        {{ $area->id === $data->area_id ? 'selected' : '' }}>{{ $area->name }}</option>
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
                        <div class="form-group w-100">
                            <label for="track" class="form-label">Lintas <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="track" id="track" style="width: 100%;">
                                @foreach ($tracks as $track)
                                    <option value="{{ $track->id }}"
                                        {{ $track->id === $data->track_id ? 'selected' : '' }}>{{ $track->code }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('track'))
                                <div class="text-danger">
                                    {{ $errors->first('track') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="form-group w-100">
                            <label for="sub_track" class="form-label">Petak <span class="text-danger ms-1">*</span></label>
                            <select class="select2 form-control" name="sub_track" id="sub_track" style="width: 100%;">
                                @foreach ($sub_tracks as $sub_track)
                                    <option value="{{ $sub_track->id }}"
                                        {{ $sub_track->id === $data->sub_track_id ? 'selected' : '' }}>
                                        {{ $sub_track->code }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('sub_track'))
                                <div class="text-danger">
                                    {{ $errors->first('sub_track') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="stakes" class="form-label">KM/HM <span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="stakes" name="stakes" placeholder="KM/HM"
                                value="{{ $data->stakes }}">
                            @if ($errors->has('stakes'))
                                <div class="text-danger">
                                    {{ $errors->first('stakes') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="recommendation_number" class="form-label">No. Surat Rekomendasi <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="recommendation_number"
                                name="recommendation_number" value="{{ $data->recommendation_number }}">
                            @if ($errors->has('recommendation_number'))
                                <div class="text-danger">
                                    {{ $errors->first('recommendation_number') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="responsible_person" class="form-label">Penanggung Jawab Bangunan <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control" id="responsible_person" name="responsible_person"
                                value="{{ $data->responsible_person }}">
                            @if ($errors->has('responsible_person'))
                                <div class="text-danger">
                                    {{ $errors->first('responsible_person') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="road_class" class="form-label">Kelas Jalan <span class="text-danger ms-1">*</span>
                            </label>
                            <input type="text" class="form-control" id="road_class" name="road_class"
                                value="{{ $data->road_class }}">
                            @if ($errors->has('road_class'))
                                <div class="text-danger">
                                    {{ $errors->first('road_class') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="long" class="form-label">Panjang Bangunan (m) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="long" name="long"
                                value="{{ $data->long }}">
                            @if ($errors->has('long'))
                                <div class="text-danger">
                                    {{ $errors->first('long') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="width" class="form-label">Lebar Bangunan (m) <span
                                    class="text-danger ms-1">*</span></label>
                            <input type="number" step="any" class="form-control" id="width" name="width"
                                value="{{ $data->width }}">
                            @if ($errors->has('width'))
                                <div class="text-danger">
                                    {{ $errors->first('width') }}
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
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        $(document).ready(function() {
            $('.select2').select2({
                width: 'resolve',
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
