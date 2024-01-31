@extends('admin/base')

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
                window.location.href = '{{ route('means.direct-passage.service-unit', ['service_unit_id' => $service_unit->id]) }}';
            })
        </script>
    @endif
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">PERLINTASAN KERETA API (JPL) {{ $service_unit->name }}</h1>
            <p class="mb-0">Manajemen Data Perlintasan Kereta Api (JPL) {{ $service_unit->name }}</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item"><a href="{{ route('means.direct-passage.service-unit', ['service_unit_id' => $service_unit->id]) }}">Perlintasan Kereta Api (JPL) {{ $service_unit->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="area" class="form-label">Wilayah <span class="text-danger ms-1">*</span></label>
                                        <select class="select2 form-control" name="area" id="area"
                                                style="width: 100%;">
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->id }}" {{ ($data->area_id === $area->id) ? 'selected' : ''  }}>{{ $area->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('area'))
                                            <div class="text-danger">
                                                {{ $errors->first('area') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="track" class="form-label">Lintas <span class="text-danger ms-1">*</span></label>
                                        <select class="select2 form-control" name="track" id="track"
                                                style="width: 100%;">
                                            @foreach ($tracks as $track)
                                                <option value="{{ $track->id }}" {{ ($data->track_id === $track->id) ? 'selected' : ''  }}>{{ $track->code }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('track'))
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
                                        <select class="select2 form-control" name="sub_track" id="sub_track"
                                                style="width: 100%;">
                                            @foreach ($sub_tracks as $sub_track)
                                                <option value="{{ $sub_track->id }}" {{ ($data->sub_track_id === $sub_track->id) ? 'selected' : ''  }}>{{ $sub_track->code }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('sub_track'))
                                            <div class="text-danger">
                                                {{ $errors->first('sub_track') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="stakes" class="form-label">KM/HM <span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" id="stakes" name="stakes"
                                               placeholder="KM/HM" value="{{ $data->stakes }}">
                                        @if($errors->has('stakes'))
                                            <div class="text-danger">
                                                {{ $errors->first('stakes') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="name" class="form-label">No. JPL <span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="JPL" value="{{ $data->name }}">
                                        @if($errors->has('name'))
                                            <div class="text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="width" class="form-label">Lebar Jalan (m) <span class="text-danger ms-1">*</span></label>
                                        <input type="number" step="any" class="form-control" id="width" name="width"
                                               placeholder="0" value="{{ $data->width }}">
                                        @if($errors->has('width'))
                                            <div class="text-danger">
                                                {{ $errors->first('width') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_class" class="form-label">Kelas Jalan <span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" id="road_class" name="road_class" value="{{ $data->road_class }}">
                                        @if($errors->has('road_class'))
                                            <div class="text-danger">
                                                {{ $errors->first('road_class') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="elevation" class="form-label">Elevasi (derajat) <span class="text-danger ms-1">*</span></label>
                                        <input type="text" step="any" class="form-control" id="elevation" name="elevation"
                                               placeholder="0" value="{{ $data->elevation }}">
                                        @if($errors->has('elevation'))
                                            <div class="text-danger">
                                                {{ $errors->first('elevation') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_construction" class="form-label">Konstruksi Jalan <span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" id="road_construction"
                                               name="road_construction"
                                               placeholder="Konstruksi Jalan" value="{{ $data->road_construction }}">
                                        @if($errors->has('road_construction'))
                                            <div class="text-danger">
                                                {{ $errors->first('road_construction') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="city" class="form-label">Kabupaten / Kota <span class="text-danger ms-1">*</span></label>
                                        <select class="select2 form-control" name="city" id="city"
                                                style="width: 100%;">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}" {{ ($city->id === $data->city_id) ? 'selected' :'' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('city'))
                                            <div class="text-danger">
                                                {{ $errors->first('city') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="latitude" class="form-label">Latitude <span class="text-danger ms-1">*</span></label>
                                        <input type="number" step="any" class="form-control" id="latitude" name="latitude"
                                               placeholder="Contoh: 7.1129489" value="{{ $data->latitude }}">
                                        @if($errors->has('latitude'))
                                            <div class="text-danger">
                                                {{ $errors->first('latitude') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="longitude" class="form-label">Longitude <span class="text-danger ms-1">*</span></label>
                                        <input type="number" step="any" class="form-control" id="longitude" name="longitude"
                                               placeholder="Contoh: 110.1129489" value="{{ $data->longitude }}">
                                        @if($errors->has('longitude'))
                                            <div class="text-danger">
                                                {{ $errors->first('longitude') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="guarded_by" class="form-label">Status Penjagaan <span class="text-danger ms-1">*</span></label>
                                        <select class="select2 form-control" name="guarded_by" id="guarded_by"
                                                style="width: 100%;">
                                            <option value="0" {{ (0 === $data->guarded_by) ? 'selected' :'' }}>OP (PT. KAI)</option>
                                            <option value="1" {{ (1 === $data->guarded_by) ? 'selected' :'' }}>JJ (PT. KAI)</option>
                                            <option value="2" {{ (2 === $data->guarded_by) ? 'selected' :'' }}>Pemda / Instansi Lain</option>
                                            <option value="3" {{ (3 === $data->guarded_by) ? 'selected' :'' }}>Resmi Tidak Dijaga</option>
                                            <option value="4" {{ (4 === $data->guarded_by) ? 'selected' :'' }}>Liar</option>
                                            <option value="5" {{ (5 === $data->guarded_by) ? 'selected' :'' }}>Swadaya</option>
                                        </select>
                                        @if($errors->has('guarded_by'))
                                            <div class="text-danger">
                                                {{ $errors->first('guarded_by') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="technical_documentation" class="form-label">No. Surat Rekomendasi Teknis <span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" id="technical_documentation"
                                               name="technical_documentation"
                                               placeholder="No. Surat Rekomendasi Teknis" value="{{ $data->technical_documentation }}">
                                        @if($errors->has('technical_documentation'))
                                            <div class="text-danger">
                                                {{ $errors->first('technical_documentation') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="is_closed" class="form-label">Status JPL <span class="text-danger ms-1">*</span></label>
                                        <select class="select2 form-control" name="is_closed" id="is_closed"
                                                style="width: 100%;">
                                            <option value="0" {{ (0 == $data->is_closed) ? 'selected' :'' }}>Aktif</option>
                                            <option value="1" {{ (1 == $data->is_closed) ? 'selected' :'' }}>Tidak Aktif</option>
                                        </select>
                                        @if($errors->has('is_closed'))
                                            <div class="text-danger">
                                                {{ $errors->first('is_closed') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="road_name" class="form-label">Nama Jalan / Daerah <span class="text-danger ms-1">*</span></label>
                                        <textarea rows="3" class="form-control" style="font-size: 0.8rem" id="road_name" name="road_name"
                                                  placeholder="Konstruksi Jalan">{{ $data->road_name }}</textarea>
                                        @if($errors->has('road_name'))
                                            <div class="text-danger">
                                                {{ $errors->first('road_name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="w-100">
                                        <label for="description" class="form-label">Keterangan</label>
                                        <textarea rows="3" class="form-control"  style="font-size: 0.8rem" id="description" name="description"
                                                  placeholder="Keterangan">{{ $data->description }}</textarea>
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
                <div id="sign-part" class="content" role="tabpanel" aria-labelledby="sign-part-trigger">
                    <div class="panel ">
                        <div class="isi">
                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/s35.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100">
                                    <label class="form-label">Peringatan Membunyikan Suling Lokomotif</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="locomotive_flute"
                                                   id="locomotive_flute_yes" value="1" {{ (1 === $data->sign_equipment->locomotive_flute) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="locomotive_flute_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="locomotive_flute"
                                                   id="locomotive_flute_no" value="0" {{ (0 === $data->sign_equipment->locomotive_flute) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="locomotive_flute_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ asset('/images/sign-equipment/8ef.jpeg') }}" class="" alt="sign-image"
                                         height="50">
                                    <img src="{{ asset('/images/sign-equipment/8ef_1.jpeg') }}" class=""
                                         alt="sign-image" height="50">
                                </div>
                                <div class="w-100">
                                    <label class="form-label">Peringatan Ada Perlintasan Kereta Api</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="crossing_exists"
                                                   id="crossing_exists_yes" value="1" {{ (1 === $data->sign_equipment->crossing_exists) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="crossing_exists_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="crossing_exists"
                                                   id="crossing_exists_no" value="0" {{ (0 === $data->sign_equipment->crossing_exists) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="crossing_exists_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/450.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100">
                                    <label class="form-label">Jarak Lokasi Kritis 450 Meter</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="critical_distance_450"
                                                   id="critical_distance_450_yes" value="1" {{ (1 === $data->sign_equipment->critical_distance_450) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="critical_distance_450_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="critical_distance_450"
                                                   id="critical_distance_450_no" value="0" {{ (0 === $data->sign_equipment->critical_distance_450) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="critical_distance_450_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/300.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100">
                                    <label class="form-label">Jarak Lokasi Kritis 300 Meter</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="critical_distance_300"
                                                   id="critical_distance_300_yes" value="1" {{ (1 === $data->sign_equipment->critical_distance_300) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="critical_distance_300_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="critical_distance_300"
                                                   id="critical_distance_300_no" value="0" {{ (0 === $data->sign_equipment->critical_distance_300) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="critical_distance_300_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/150.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100 mb-3">
                                    <label class="form-label">Jarak Lokasi Kritis 100 Meter</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="critical_distance_100"
                                                   id="critical_distance_100_yes" value="1" {{ (1 === $data->sign_equipment->critical_distance_100) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="critical_distance_100_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="critical_distance_100"
                                                   id="critical_distance_100_no" value="0" {{ (0 === $data->sign_equipment->critical_distance_100) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="critical_distance_100_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/stop.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100">
                                    <label class="form-label">1A (Rambu STOP)</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="stop_sign"
                                                   id="stop_sign_yes" value="1" {{ (1 === $data->sign_equipment->stop_sign) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="stop_sign_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="stop_sign"
                                                   id="stop_sign_no" value="0" {{ (0 === $data->sign_equipment->stop_sign) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="stop_sign_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ asset('/images/sign-equipment/1ef.jpeg') }}" class="" alt="sign-image"
                                         height="50">
                                    <img src="{{ asset('/images/sign-equipment/1ef_1.jpeg') }}" class=""
                                         alt="sign-image" height="50">
                                </div>
                                <div class="w-100">
                                    <label class="form-label">Larangan Berjalan (Silang Andreas)</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="walking_ban"
                                                   id="walking_ban_yes" value="1" {{ (1 === $data->sign_equipment->walking_ban) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="walking_ban_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="walking_ban"
                                                   id="walking_ban_no" value="0" {{ (0 === $data->sign_equipment->walking_ban) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="walking_ban_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


{{--                            <div class="w-100 mb-3">--}}
{{--                                <label class="form-label">Peringatan Rintangan Obyek Berbahaya</label>--}}
{{--                                <div class="form-group">--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="radio" name="obstacles"--}}
{{--                                               id="obstacles_yes" value="1" {{ (1 === $data->sign_equipment->obstacles) ? 'checked' :'' }}>--}}
{{--                                        <label class="form-check-label" for="obstacles_yes">ADA</label>--}}
{{--                                    </div>--}}
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="radio" name="obstacles"--}}
{{--                                               id="obstacles_no" value="0" {{ (0 === $data->sign_equipment->obstacles) ? 'checked' :'' }}>--}}
{{--                                        <label class="form-check-label" for="obstacles_no">TIDAK ADA</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/pita-penggaduh.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100">
                                    <label class="form-label">Pita Penggaduh</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="noise_band"
                                                   id="noise_band_yes" value="1" {{ (1 === $data->sign_equipment->noise_band) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="noise_band_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="noise_band"
                                                   id="noise_band_no" value="0" {{ (0 === $data->sign_equipment->noise_band) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="noise_band_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/hati-hati.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100">
                                    <label class="form-label">Hati Hati Mendekati Perlintasan</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="approach"
                                                   id="approach_yes" value="1" {{ (1 === $data->sign_equipment->approach) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="approach_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="approach"
                                                   id="approach_no" value="0" {{ (0 === $data->sign_equipment->approach) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="approach_no">TIDAK ADA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <img src="{{ asset('/images/sign-equipment/berhenti-tengok.jpeg') }}" class="mb-2" alt="sign-image"
                                     height="50">
                                <div class="w-100">
                                    <label class="form-label">Berhenti Tengok Kiri Kanan</label>
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="look_around"
                                                   id="look_around_yes" value="1" {{ (1 === $data->sign_equipment->look_around) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="look_around_yes">ADA</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="look_around"
                                                   id="look_around_no" value="0" {{ (0 === $data->sign_equipment->look_around) ? 'checked' :'' }}>
                                            <label class="form-check-label" for="look_around_no">TIDAK ADA</label>
                                        </div>
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
