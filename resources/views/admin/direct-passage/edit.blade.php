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
                text: 'Berhasil Merubah Data...',
                icon: 'success',
                timer: 1000
            }).then(() => {
                window.location.href = '{{ route('direct-passage') }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">JALUR PERLINTASAN LANGSUNG</h1>
            <p class="mb-0">Manajemen Edit Data Jalur Perlintasan Langsung</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('direct-passage') }}">Jalur Perlintasan Langsung</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <form method="post" id="form-data">
        @csrf
        <div class="bs-stepper">
            <div class="bs-stepper-header" role="tablist">
                <div class="step" data-target="#common-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="common-part"
                            id="common-part-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Data Umum</span>
                    </button>
                </div>
                {{--                <div class="line"></div>--}}
                {{--                <div class="step" data-target="#guard-part">--}}
                {{--                    <button type="button" class="step-trigger" role="tab" aria-controls="guard-part"--}}
                {{--                            id="guard-part-trigger">--}}
                {{--                        <span class="bs-stepper-circle">2</span>--}}
                {{--                        <span class="bs-stepper-label">Status Penjagaan</span>--}}
                {{--                    </button>--}}
                {{--                </div>--}}
                <div class="line"></div>
                <div class="step" data-target="#sign-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="sign-part"
                            id="sign-part-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Perlengkapan Rambu</span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <div id="common-part" class="content" role="tabpanel" aria-labelledby="common-part-trigger">
                    <div class="panel ">
                        <div class="isi">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="sub_track" class="form-label">Lintas Antara</label>
                                        <select class="select2 form-control" name="sub_track" id="sub_track"
                                                style="width: 100%;">
                                            @foreach ($sub_tracks as $sub_track)
                                                <option value="{{ $sub_track->id }}">{{ $sub_track->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="name" class="form-label">JPL</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="JPL">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="stakes" class="form-label">KM/HM</label>
                                        <input type="text" class="form-control" id="stakes" name="stakes"
                                               placeholder="KM/HM">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="accident_history" class="form-label">Riwayat Kecelakaan</label>
                                        <input type="number" class="form-control" id="accident_history"
                                               name="accident_history"
                                               placeholder="0" value="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="width" class="form-label">Lebar Jalan (m)</label>
                                        <input type="number" step="any" class="form-control" id="width" name="width"
                                               placeholder="0" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_construction" class="form-label">Konstruksi Jalan</label>
                                        <input type="text" class="form-control" id="road_construction"
                                               name="road_construction"
                                               placeholder="Konstruksi Jalan">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="city" class="form-label">Kota</label>
                                        <select class="select2 form-control" name="city" id="city"
                                                style="width: 100%;">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="latitude" class="form-label">Latitude</label>
                                        <input type="number" step="any" class="form-control" id="latitude" name="latitude"
                                               placeholder="Contoh: 7.1129489">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="longitude" class="form-label">Longitude</label>
                                        <input type="number" step="any" class="form-control" id="longitude" name="longitude"
                                               placeholder="Contoh: 110.1129489">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="guarded_by" class="form-label">Status Penjagaan</label>
                                        <select class="select2 form-control" name="guarded_by" id="guarded_by"
                                                style="width: 100%;">
                                            <option value="0">OP (PT. KAI)</option>
                                            <option value="1">JJ (PT. KAI)</option>
                                            <option value="2">Instansi Lain</option>
                                            <option value="3">Resmi Tidak Dijaga</option>
                                            <option value="4">Liar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_name" class="form-label">Nama Jalan / Daerah</label>
                                        <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="road_name" name="road_name"
                                                  placeholder="Konstruksi Jalan"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea rows="3" class="form-control"  style="font-size: 0.8rem" id="description" name="description"
                                                  placeholder="Keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-end">
                                <a class="btn-utama rnd btn-next" id="btn-next-step-1" href="#">Selanjutnya
                                    <i class="material-symbols-outlined menu-icon ms-1 text-white">chevron_right</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div id="guard-part" class="content" role="tabpanel" aria-labelledby="guard-part-trigger">--}}
                {{--                    <div class="panel ">--}}
                {{--                        <div class="isi">--}}
                {{--                            <p class="mb-0 fw-bold">PT. KAI</p>--}}
                {{--                            <hr>--}}
                {{--                            <div class="w-100 mb-3">--}}
                {{--                                <label class="form-label">Resmi Di Jaga OP</label>--}}
                {{--                                <div class="form-group">--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_operator"--}}
                {{--                                               id="is_verified_by_operator_yes" value="1">--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_operator_yes">YA</label>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_operator"--}}
                {{--                                               id="is_verified_by_operator_no" value="0" checked>--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_operator_no">TIDAK</label>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="w-100 mb-3">--}}
                {{--                                <label class="form-label">Resmi Di Jaga JJ</label>--}}
                {{--                                <div class="form-group">--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_unit_track_and_bridge"--}}
                {{--                                               id="is_verified_by_unit_track_and_bridge_yes" value="1">--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_unit_track_and_bridge_yes">YA</label>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_unit_track_and_bridge"--}}
                {{--                                               id="is_verified_by_unit_track_and_bridge_no" value="0" checked>--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_unit_track_and_bridge_no">TIDAK</label>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <hr>--}}
                {{--                            <p class="mb-0 fw-bold">Pemda</p>--}}
                {{--                            <hr>--}}
                {{--                            <div class="w-100 mb-3">--}}
                {{--                                <label class="form-label">Resmi Di Jaga Instansi Lain</label>--}}
                {{--                                <div class="form-group">--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_institution"--}}
                {{--                                               id="is_verified_by_institution_yes" value="1">--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_institution_yes">YA</label>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_institution"--}}
                {{--                                               id="is_verified_by_institution_no" value="0" checked>--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_institution_no">TIDAK</label>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <hr>--}}
                {{--                            <p class="mb-0 fw-bold">Lainnya</p>--}}
                {{--                            <hr>--}}
                {{--                            <div class="w-100 mb-3">--}}
                {{--                                <label class="form-label">Resmi Tidak Di Jaga</label>--}}
                {{--                                <div class="form-group">--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_unguarded"--}}
                {{--                                               id="is_verified_by_unguarded_yes" value="1">--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_unguarded_yes">YA</label>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_verified_by_unguarded"--}}
                {{--                                               id="is_verified_by_unguarded_no" value="0" checked>--}}
                {{--                                        <label class="form-check-label" for="is_verified_by_unguarded_no">TIDAK</label>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="w-100 mb-3">--}}
                {{--                                <label class="form-label">Liar</label>--}}
                {{--                                <div class="form-group">--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_illegal"--}}
                {{--                                               id="is_illegal_yes" value="1">--}}
                {{--                                        <label class="form-check-label" for="is_illegal_yes">YA</label>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="form-check form-check-inline">--}}
                {{--                                        <input class="form-check-input" type="radio" name="is_illegal"--}}
                {{--                                               id="is_illegal_no" value="0" checked>--}}
                {{--                                        <label class="form-check-label" for="is_illegal_no">TIDAK</label>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <hr>--}}
                {{--                            <div class="d-flex justify-content-end">--}}
                {{--                                <div class="d-flex align-items-center">--}}
                {{--                                    <a class="btn-utama rnd me-3" id="btn-prev-step-2" href="#">--}}
                {{--                                        <i class="material-symbols-outlined menu-icon me-1 text-white">chevron_left</i>--}}
                {{--                                        Sebelumnya--}}
                {{--                                    </a>--}}
                {{--                                    <a class="btn-utama rnd" id="btn-next-step-2" href="#">Selanjutnya--}}
                {{--                                        <i class="material-symbols-outlined menu-icon ms-1 text-white">chevron_right</i>--}}
                {{--                                    </a>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div id="sign-part" class="content" role="tabpanel" aria-labelledby="sign-part-trigger">
                    <div class="panel ">
                        <div class="isi">
                            <div class="w-100 mb-3">
                                <label class="form-label">Peringatan Membunyikan Suling Lokomotif</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="locomotive_flute"
                                               id="locomotive_flute_yes" value="1">
                                        <label class="form-check-label" for="locomotive_flute_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="locomotive_flute"
                                               id="locomotive_flute_no" value="0" checked>
                                        <label class="form-check-label" for="locomotive_flute_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Peringatan Pintu Perlintasan Sebidang</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="crossing_gate"
                                               id="crossing_gate_yes" value="1">
                                        <label class="form-check-label" for="crossing_gate_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="crossing_gate"
                                               id="crossing_gate_no" value="0" checked>
                                        <label class="form-check-label" for="crossing_gate_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Peringatan Tanpa Pintu Perlintasan Sebidang</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="non_crossing_gate"
                                               id="non_crossing_gate_yes" value="1">
                                        <label class="form-check-label" for="non_crossing_gate_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="non_crossing_gate"
                                               id="non_crossing_gate_no" value="0" checked>
                                        <label class="form-check-label" for="non_crossing_gate_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Peringatan</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="warning"
                                               id="warning_yes" value="1">
                                        <label class="form-check-label" for="warning_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="warning"
                                               id="warning_no" value="0" checked>
                                        <label class="form-check-label" for="warning_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Jarak Lokasi Kritis 450 Meter</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="critical_distance_450"
                                               id="critical_distance_450_yes" value="1">
                                        <label class="form-check-label" for="critical_distance_450_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="critical_distance_450"
                                               id="critical_distance_450_no" value="0" checked>
                                        <label class="form-check-label" for="critical_distance_450_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Jarak Lokasi Kritis 300 Meter</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="critical_distance_300"
                                               id="critical_distance_300_yes" value="1">
                                        <label class="form-check-label" for="critical_distance_300_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="critical_distance_300"
                                               id="critical_distance_300_no" value="0" checked>
                                        <label class="form-check-label" for="critical_distance_300_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Jarak Lokasi Kritis 100 Meter</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="critical_distance_100"
                                               id="critical_distance_100_yes" value="1">
                                        <label class="form-check-label" for="critical_distance_100_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="critical_distance_100"
                                               id="critical_distance_100_no" value="0" checked>
                                        <label class="form-check-label" for="critical_distance_100_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Rambu STOP</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stop_sign"
                                               id="stop_sign_yes" value="1">
                                        <label class="form-check-label" for="stop_sign_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="stop_sign"
                                               id="stop_sign_no" value="0" checked>
                                        <label class="form-check-label" for="stop_sign_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Larangan Berjalan</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="walking_ban"
                                               id="walking_ban_yes" value="1">
                                        <label class="form-check-label" for="walking_ban_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="walking_ban"
                                               id="walking_ban_no" value="0" checked>
                                        <label class="form-check-label" for="walking_ban_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Larangan Masuk Kendaraan</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vehicle_entry_ban"
                                               id="vehicle_entry_ban_yes" value="1">
                                        <label class="form-check-label" for="vehicle_entry_ban_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vehicle_entry_ban"
                                               id="vehicle_entry_ban_no" value="0" checked>
                                        <label class="form-check-label" for="vehicle_entry_ban_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 mb-3">
                                <label class="form-label">Garis Kejut</label>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="shock_line"
                                               id="shock_line_yes" value="1">
                                        <label class="form-check-label" for="shock_line_yes">ADA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="shock_line"
                                               id="shock_line_no" value="0" checked>
                                        <label class="form-check-label" for="shock_line_no">TIDAK ADA</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-end">
                                <div class="d-flex align-items-center">
                                    <a class="btn-utama rnd me-3 btn-prev" id="btn-prev-step-3" href="#">
                                        <i class="material-symbols-outlined menu-icon me-1 text-white">chevron_left</i>
                                        Sebelumnya
                                    </a>
                                    <a class="btn-utama rnd" id="btn-save" href="#">Simpan
                                        <i class="material-symbols-outlined menu-icon ms-1 text-white">save</i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css" rel="stylesheet"/>
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script>
        $(document).ready(function () {
            var stepper = new Stepper($('.bs-stepper')[0], {
                linear: true
            });
            $('.select2').select2({
                width: 'resolve',
            });

            $('.btn-next').on('click', function (e) {
                e.preventDefault();
                stepper.next();
            });

            $('.btn-prev').on('click', function (e) {
                e.preventDefault();
                stepper.previous();
            });

            // $('#btn-next-step-1').on('click', function (e) {
            //     e.preventDefault();
            //     stepper.to(2)
            // });
            // $('#btn-prev-step-2').on('click', function (e) {
            //     e.preventDefault();
            //     stepper.to(1)
            // });
            // $('#btn-next-step-2').on('click', function (e) {
            //     e.preventDefault();
            //     stepper.to(3)
            // });
            // $('#btn-prev-step-3').on('click', function (e) {
            //     e.preventDefault();
            //     stepper.to(2)
            // });

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
