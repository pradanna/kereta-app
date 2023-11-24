<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Aplikasi Kereta Api</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/appstyle/genosstyle.1.0.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- ICON --}}
    <link rel="shortcut icon" href="{{ asset('images/local/favicon.ico') }}" title="Favicon" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="{{ asset('css/dropify/css/dropify.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
        rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
    <style>
        ul {
            list-style: none;
        }
    </style>
    @yield('css')
</head>

<body>
    <div class="header">
        <div class="header-panel-kiri">
            {{-- <a class="btn-icon " onclick="openNav()">
                <span class="material-symbols-outlined">menu
                </span>
            </a> --}}
            <a class="btn-icon ">
                <img class="t-30" src="{{ asset('images/local/logodishub.png') }}" />
                <img class="t-30" src="{{ asset('images/local/logodjka.png') }}" />
                <img class="t-30" src="{{ asset('images/local/logo_btp.png') }}" />
            </a>
        </div>

        <p class="text-title text-center">
            @yield('title')
        </p>
        <div class="header-panel-kanan">
            <a class="profil dropdown-toggle" href="#" role="button" id="dropdownprofile"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('images/local/nobody.png') }}" />
            </a>
            <ul class="dropdown-menu custom" aria-labelledby="dropdownprofile">
                <li><a class="dropdown-item disabled" href="#">admin</a></li>
                <hr>
                {{-- <li><a class="dropdown-item" href="#">Another action</a></li> --}}
                <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
            </ul>
            <ul class="dropdown-menu custom" aria-labelledby="dropdownprofile">
                <li><a class="dropdown-item disabled" href="#">admin</a></li>
                <hr>
                <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="d-flex flex-nowrap " style="max-width: 100%; position: relative;">
        <nav id="sidebar" class="sidebar card py-2" style="min-height: 100vh; ">
            <ul class="nav flex-column " style=" " id="nav_accordion">

                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <span class="material-symbols-outlined menu-icon">
                            home
                        </span>
                        <p class="menu-text">Dashboard</p>
                    </a>
                </li>

                @php
                    $master = ['satuan-pelayanan', 'daerah-operasi', 'depo-dan-balai-yasa', 'kecamatan'];
                    $openMaster = false;
                    foreach ($master as $m) {
                        if (request()->is($m . '*')) {
                            $openMaster = true;
                            break;
                        }
                    }
                @endphp

                <li class="nav-item">
                    <a class="nav-link menu">
                        <span class="material-symbols-outlined menu-icon">
                            linked_services
                        </span>
                        <p class="menu-text {{ in_array(request()->path(), $master) || $openMaster ? 'fw-bold' : '' }}">
                            Master Data Operasional
                        </p>
                    </a>
                    <ul class="{{ in_array(request()->path(), $master) || $openMaster ? '' : 'collapse' }}">
                        <li class="nav-item ">
                            <a class="nav-link menu {{ request()->is('satuan-pelayanan*') ? 'active' : '' }}"
                               href="{{ route('service-unit') }}">
                                <p class="menu-text">Satuan Pelayanan (SATPEL)</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link menu {{ request()->is('daerah-operasi*') ? 'active' : '' }}"
                               href="{{ route('area') }}">

                                <p class="menu-text">Daerah Operasi (DAOP)</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link menu {{ request()->is('depo-dan-balai-yasa*') ? 'active' : '' }}"
                               href="{{ route('storehouse') }}">
                                <p class="menu-text">Depo dan Balai Yasa</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link menu {{ request()->is('kecamatan*') ? 'active' : '' }}"
                               href="{{ route('district') }}">
                                <p class="menu-text">Kecamatan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $masterFacility = ['jenis-lokomotif', 'jenis-kereta', 'jenis-gerbong', 'sub-jenis-gerbong', 'jenis-peralatan-khusus'];
                    $openMasterFacility = false;
                    foreach ($masterFacility as $mf) {
                        if (request()->is($mf . '*')) {
                            $openMasterFacility = true;
                            break;
                        }
                    }
                @endphp
                <li class="nav-item ">
                    <a class="nav-link menu">
                        <span class="material-symbols-outlined menu-icon">
                            label_important
                        </span>
                        <p class="menu-text {{ in_array(request()->path(), $masterFacility) || $openMasterFacility ? 'fw-bold' : '' }}">
                            Master Data Jenis Sarana
                        </p>
                    </a>
                    <ul class="{{ in_array(request()->path(), $masterFacility) || $openMasterFacility ? '' : 'collapse' }}">
                        <li class="nav-item ">
                            <a class="nav-link menu {{ request()->is('jenis-lokomotif*') ? 'active' : '' }}"
                                href="{{ route('locomotive-type') }}">
                                <p class="menu-text">Jenis Lokomotif</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link menu {{ request()->is('jenis-kereta*') ? 'active' : '' }}"
                                href="{{ route('train-type') }}">
                                <p class="menu-text">Jenis Kereta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('jenis-gerbong*') ? 'active' : '' }}"
                                href="{{ route('wagon-type') }}">
                                <p class="menu-text">Jenis Gerbong</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('sub-jenis-gerbong*') ? 'active' : '' }}"
                                href="{{ route('wagon-sub-type') }}">
                                <p class="menu-text">Sub Jenis Gerbong</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('jenis-peralatan-khusus*') ? 'active' : '' }}"
                                href="{{ route('special-equipment-type') }}">
                                <p class="menu-text">Jenis Peralatan Khusus</p>
                            </a>
                        </li>

                    </ul>
                </li>

                @php
                    $masterTrack = ['perlintasan', 'petak', 'jenis-rawan-bencana', 'resort'];
                    $openMasterTrack = false;
                    foreach ($masterTrack as $mt) {
                        if (request()->is($mt . '*')) {
                            $openMasterTrack = true;
                            break;
                        }
                    }
                @endphp
                <li class="nav-item">
                    <a class="nav-link menu">
                        <span class="material-symbols-outlined menu-icon">
                            data_exploration
                        </span>
                        <p class="menu-text {{ in_array(request()->path(), $masterTrack) || $openMasterTrack ? 'fw-bold' : '' }}">
                            Master Data Perlintasan
                        </p>
                    </a>
                    <ul class="{{ in_array(request()->path(), $masterTrack) || $openMasterTrack ? '' : 'collapse' }}">
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('perlintasan*') ? 'active' : '' }}"
                               href="{{ route('track') }}">
                                <p class="menu-text">Perlintasan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('petak*') ? 'active' : '' }}"
                               href="{{ route('sub-track') }}">
                                <p class="menu-text">Petak</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('jenis-rawan-bencana*') ? 'active' : '' }}"
                               href="{{ route('disaster-type') }}">
                                <p class="menu-text">Jenis Rawan Bencana</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('resort*') ? 'active' : '' }}"
                               href="{{ route('resort') }}">
                                <p class="menu-text">Resort</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @php
                    $certification = ['sertifikasi-sarana-lokomotif', 'sertifikasi-sarana-kereta', 'sertifikasi-sarana-kereta-diesel', 'sertifikasi-sarana-gerbong', 'sertifikasi-sarana-peralatan-khusus'];
                    $openCertification = false;
                    foreach ($certification as $c) {
                        if (request()->is($c . '*')) {
                            $openCertification = true;
                            break;
                        }
                    }
                @endphp
                <li class="nav-item">
                    <a class="nav-link menu">
                        <span class="material-symbols-outlined menu-icon">
                            card_membership
                        </span>
                        <p
                            class="menu-text {{ in_array(request()->path(), $certification) || $openCertification ? 'fw-bold' : '' }}">
                            Sertifikasi Sarana</p>
                    </a>
                    <ul
                        class="{{ in_array(request()->path(), $certification) || $openCertification ? '' : 'collapse' }}">
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('sertifikasi-sarana-lokomotif*') ? 'active' : '' }}"
                                href="{{ route('facility-certification-locomotive') }}">
                                <p class="menu-text">Lokomotif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('sertifikasi-sarana-kereta') || request()->is('sertifikasi-sarana-kereta/*') ? 'active' : '' }}"
                                href="{{ route('facility-certification-train') }}">
                                <p class="menu-text">Kereta</p>
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link menu {{ request()->is('sertifikasi-sarana-kereta-diesel*') ? 'active' : '' }}"--}}
{{--                                href="{{ route('facility-certification-train-diesel') }}">--}}
{{--                                <p class="menu-text">KRD</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link menu {{ request()->is('sertifikasi-sarana-kereta-listrik*') ? 'active' : '' }}"--}}
{{--                                href="{{ route('facility-certification-train-electric') }}">--}}
{{--                                <p class="menu-text">KRL</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('sertifikasi-sarana-gerbong*') ? 'active' : '' }}"
                                href="{{ route('facility-certification-wagon') }}">
                                <p class="menu-text">Gerbong</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('sertifikasi-sarana-peralatan-khusus*') ? 'active' : '' }}"
                                href="{{ route('facility-certification-special-equipment') }}">
                                <p class="menu-text">Peralatan Khusus</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $technicalSpec = ['spesifikasi-teknis-sarana-lokomotif', 'spesifikasi-teknis-sarana-kereta', 'spesifikasi-teknis-sarana-gerbong', 'spesifikasi-teknis-sarana-peralatan-khusus'];
                    $openTechnicalSpec = false;
                    foreach ($technicalSpec as $t) {
                        if (request()->is($t . '*')) {
                            $openTechnicalSpec = true;
                            break;
                        }
                    }
                @endphp
                <li class="nav-item">
                    <a class="nav-link menu" href="#">
                        <span class="material-symbols-outlined menu-icon">
                            train
                        </span>
                        <p
                            class="menu-text {{ in_array(request()->path(), $technicalSpec) || $openTechnicalSpec ? 'fw-bold' : '' }}">
                            Spesifikasi Teknis Sarana</p>
                    </a>
                    <ul
                        class="{{ in_array(request()->path(), $technicalSpec) || $openTechnicalSpec ? '' : 'collapse' }}">
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('spesifikasi-teknis-sarana-lokomotif*') ? 'active' : '' }}"
                                href="{{ route('technical-specification.locomotive') }}">
                                <p class="menu-text">Lokomotif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('spesifikasi-teknis-sarana-kereta*') ? 'active' : '' }}"
                                href="{{ route('technical-specification.train') }}">
                                <p class="menu-text">Kereta</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('spesifikasi-teknis-sarana-gerbong') ? 'active' : '' }}"
                                href="{{ route('technical-specification.wagon') }}">

                                <p class="menu-text">Gerbong</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('spesifikasi-teknis-sarana-peralatan-khusus') ? 'active' : '' }}"
                                href="{{ route('technical-specification.special-equipment') }}">

                                <p class="menu-text">Peralatan Khusus</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('jalur-perlintasan-langsung*') ? 'active' : '' }}"
                        href="{{ route('direct-passage') }}">
                        <span class="material-symbols-outlined menu-icon">
                            timeline
                        </span>
                        <p class="menu-text">Jalur Perlintasan Langsung</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('daerah-rawan-bencana*') ? 'active' : '' }}"
                        href="{{ route('disaster-area') }}">
                        <span class="material-symbols-outlined menu-icon">
                            flood
                        </span>
                        <p class="menu-text">Daerah Rawan Bencana</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('bangunan-liar*') ? 'active' : '' }}"
                        href="{{ route('illegal-building') }}">
                        <span class="material-symbols-outlined menu-icon">
                            domain
                        </span>
                        <p class="menu-text">Bangunan Liar</p>
                    </a>
                </li>
                @php
                    $summary = ['rekapitulasi-sarana', 'rekapitulasi-jalur-perlintasan-langsung'];
                    $openSummary = false;
                    foreach ($summary as $s) {
                        if (request()->is($s . '*')) {
                            $openSummary = true;
                            break;
                        }
                    }
                @endphp
                <li class="nav-item">
                    <a class="nav-link menu" href="#">
                        <span class="material-symbols-outlined menu-icon">
                            summarize
                        </span>
                        <p
                            class="menu-text {{ in_array(request()->path(), $summary) || $openSummary ? 'fw-bold' : '' }}">
                            Rekapitulasi</p>
                    </a>
                    <ul class="{{ in_array(request()->path(), $summary) || $openSummary ? '' : 'collapse' }}">
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('rekapitulasi-sarana*') ? 'active' : '' }}"
                                href="{{ route('summary-facility') }}">
                                <p class="menu-text">Sarana</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu {{ request()->is('rekapitulasi-jalur-perlintasan-langsung*') ? 'active' : '' }}"
                                href="{{ route('summary-direct-passage') }}">
                                <p class="menu-text">Jalur Perlintasan Langsung</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu {{ request()->is('pengguna*') ? 'active' : '' }}"
                       href="{{ route('user') }}">
                        <span class="material-symbols-outlined menu-icon">
                            person
                        </span>
                        <p class="menu-text">Pengguna</p>
                    </a>
                </li>
                <li class="nav-item text-center mt-3 mb-3">

                    <a class="title1-role " href="#"> Login Sebagai </a> <br>
                    <a class="title-role " href="#"> Admin </a>
                </li>

                {{-- <li class="nav-item">
        <a class="nav-link menu" href="/logout">
            <i class="material-symbols-outlined menu-icon">person</i>
            <p class="menu-text">Logout</p>
        </a>
    </li> --}}
            </ul>
        </nav>


        <div class="flex-fill p-4" style="max-width: 100% !important; position: relative;  overflow: hidden;">
            @yield('content')
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/base.js') }}"></script>
    {{--    <script src="{{ asset('css/dropify/js/dropify.js') }}"></script> --}}

    {{--    <script src="{{ asset('js/dialog.js?v=2') }}"></script> --}}
    {{--    <script type="text/javascript" --}}
    {{--        src="https://cdn.jsdelivr.net/npm/browser-image-compression@latest/dist/browser-image-compression.js"></script> --}}
    {{--    <script src="{{ asset('js/handler_image.js') }}"></script> --}}
    {{--    <script src="{{ asset('js/moment.min.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{--    <script> --}}
    {{--        jQuery.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) { --}}
    {{--            return { --}}
    {{--                "iStart": oSettings._iDisplayStart, --}}
    {{--                "iEnd": oSettings.fnDisplayEnd(), --}}
    {{--                "iLength": oSettings._iDisplayLength, --}}
    {{--                "iTotal": oSettings.fnRecordsTotal(), --}}
    {{--                "iFilteredTotal": oSettings.fnRecordsDisplay(), --}}
    {{--                "iPage": oSettings._iDisplayLength === -1 ? --}}
    {{--                    0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength), --}}
    {{--                "iTotalPages": oSettings._iDisplayLength === -1 ? --}}
    {{--                    0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength) --}}
    {{--            }; --}}
    {{--        }; --}}
    {{--    </script> --}}

    @yield('js')

</body>

</html>
