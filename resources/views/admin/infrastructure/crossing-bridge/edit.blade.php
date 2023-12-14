@extends('admin.base')

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
                text: 'Berhasil Merubah Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('infrastructure.crossing.bridge.main', ['service_unit_id' => $service_unit->id]) }}';
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
                        href="{{ route('infrastructure.crossing.bridge.main', ['service_unit_id' => $service_unit->id]) }}">Jembatan Penyebrangan {{ $service_unit->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="panel ">
            <div class="title">
                <p>Tambah Data Safety Assessment</p>
            </div>
            <div class="isi">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-group w-100">
                            <label for="sub_track" class="form-label">Petak</label>
                            <select class="select2 form-control" name="sub_track" id="sub_track"
                                    style="width: 100%;">
                                @foreach ($sub_tracks as $sub_track)
                                    <option
                                        value="{{ $sub_track->id }}" {{ ($sub_track->id === $data->sub_track_id) ? 'selected' : '' }}>{{ $sub_track->code }}
                                        ({{ $sub_track->track->code }} {{ $sub_track->track->area->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="stakes" class="form-label">KM/HM</label>
                            <input type="text" class="form-control" id="stakes" name="stakes"
                                   placeholder="KM/HM" value="{{ $data->stakes }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="recommendation_number" class="form-label">No. Surat Rekomendasi</label>
                            <input type="text" class="form-control" id="recommendation_number"
                                   name="recommendation_number" value="{{ $data->recommendation_number }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="responsible_person" class="form-label">Penanggung Jawab Bangunan</label>
                            <input type="text" class="form-control" id="responsible_person"
                                   name="responsible_person" value="{{ $data->responsible_person }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="road_class" class="form-label">Kelas Jalan</label>
                            <input type="text" class="form-control" id="road_class"
                                   name="road_class" value="{{ $data->road_class }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="w-100">
                            <label for="long" class="form-label">Panjang Bangunan (m)</label>
                            <input type="number" step="any" class="form-control" id="long"
                                   name="long" value="{{ $data->long }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="w-100">
                            <label for="width" class="form-label">Lebar Bangunan (m)</label>
                            <input type="number" step="any" class="form-control" id="width"
                                   name="width" value="{{ $data->width }}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="w-100">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea rows="3" class="form-control" id="description"
                                      name="description">{{ $data->description }}</textarea>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '/{{ request()->path() }}';
        $(document).ready(function () {
            $('.select2').select2({
                width: 'resolve',
            });
            $('#btn-save').on('click', function (e) {
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
