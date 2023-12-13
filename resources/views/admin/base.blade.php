<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Aplikasi Kereta Api</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/appstyle/genosstyle.1.0.css') }}" type="text/css"> --}}

    <link rel="stylesheet" href="{{ asset('css/appstyle/admin-genosstyle.css') }}" type="text/css">
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
    <div class="d-flex admin ">

        {{-- SIDEBAR --}}
        <div class="sidebar ">
            <div class="logo-container">
                <img class="company-logos" src="{{ asset('images/local/logopanjang.png') }}" />
                <img class="company-logos-minimize" src="{{ asset('images/local/logodishub.png') }}" />


            </div>
            <div class="menu-container">

                <ul>
                    <li>
                        <a class=" menu  tooltip {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}"><span class="material-symbols-outlined">
                                home
                            </span>
                            <span class="text-menu"> Dashboard</span>
                            <span class="tooltiptext">Dashboard</span>
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

                    <li>
                        <a class="menu multiple tooltip" href="#linked_services" data-bs-toggle="collapse">
                            <span class="material-symbols-outlined ">
                                linked_services
                            </span>

                            <span
                                class="text-menu {{ in_array(request()->path(), $master) || $openMaster ? 'fw-bold' : '' }}">
                                Master Data Operasional</span>
                            <span class="tooltiptext">Master Data Operasional</span>
                            <span class="material-symbols-outlined iconbtn">
                                arrow_drop_up
                            </span>

                        </a>
                        <ul id="linked_services"
                            class="  nav flex-column ms-1 {{ in_array(request()->path(), $master) || $openMaster ? '' : 'collapse' }}">

                            <li class="nav-item ">
                                <a class="menu tooltip {{ request()->is('satuan-pelayanan*') ? 'active' : '' }}"
                                    href="{{ route('service-unit') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Satuan Pelayanan (SATPEL)</span>
                                    <span class="tooltiptext">Satuan Pelayanan (SATPEL)</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="menu tooltip {{ request()->is('daerah-operasi*') ? 'active' : '' }}"
                                    href="{{ route('area') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Daerah Operasi (DAOP)</span>
                                    <span class="tooltiptext">Daerah Operasi (DAOP)</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="menu tooltip {{ request()->is('depo-dan-balai-yasa*') ? 'active' : '' }}"
                                    href="{{ route('storehouse') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Depo dan Balai Yasa</span>
                                    <span class="tooltiptext">Depo dan Balai Yasa</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="menu tooltip {{ request()->is('kecamatan*') ? 'active' : '' }}"
                                    href="{{ route('district') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Kecamatan</span>
                                    <span class="tooltiptext">Kecamatan</span>
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

                    <li>
                        <a class="menu multiple tooltip" href="#label_important">
                            <span class="material-symbols-outlined ">
                                label_important
                            </span>
                            <span
                                class="text-menu {{ in_array(request()->path(), $master) || $openMaster ? 'fw-bold' : '' }}">
                                Master Data Operasional</span>
                            <span class="tooltiptext">Master Data Operasional</span>
                            <span class="material-symbols-outlined iconbtn">
                                arrow_drop_up
                            </span>
                        </a>
                        <ul id="label_important"
                            class="nav flex-column ms-1 {{ in_array(request()->path(), $masterFacility) || $openMasterFacility ? '' : 'collapse' }}">
                            <li class="nav-item ">
                                <a class="nav-link menu {{ request()->is('jenis-lokomotif*') ? 'active' : '' }}"
                                    href="{{ route('locomotive-type') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Jenis Lokomotif</span>
                                    <span class="tooltiptext">Jenis Lokomotif</span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link menu {{ request()->is('jenis-kereta*') ? 'active' : '' }}"
                                    href="{{ route('train-type') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Jenis Kereta</span>
                                    <span class="tooltiptext">Jenis Kereta</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu {{ request()->is('jenis-gerbong*') ? 'active' : '' }}"
                                    href="{{ route('wagon-type') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Jenis Gerbong</span>
                                    <span class="tooltiptext">Jenis Gerbong</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu {{ request()->is('sub-jenis-gerbong*') ? 'active' : '' }}"
                                    href="{{ route('wagon-sub-type') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Sub Jenis Gerbong</span>
                                    <span class="tooltiptext">Sub Jenis Gerbong</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu {{ request()->is('jenis-peralatan-khusus*') ? 'active' : '' }}"
                                    href="{{ route('special-equipment-type') }}">
                                    <span class="material-symbols-outlined">
                                        fiber_manual_record
                                    </span> <span class="text-menu">Jenis Peralatan Khusus</span>
                                    <span class="tooltiptext">Jenis Peralatan Khusus</span>
                                </a>
                            </li>

                        </ul>
                    </li>



                </ul>

                <div class="footer">
                    <p class="top">Login Sebagai</p>
                    <p class="bot">Admin</p>
                </div>
            </div>
        </div>


        {{-- BODY --}}
        <div class="gen-body  ">

            {{-- NAVBAR --}}
            <div class="gen-nav">
                <div class="start">
                    <a class="nav-button">
                        <span class="iconfwd material-symbols-outlined">
                            arrow_forward
                        </span>
                        <span class="iconback material-symbols-outlined">
                            arrow_back
                        </span>
                    </a>

                    <p class="text-title text-center mb-0 ms-3  ">
                        @yield('title')
                    </p>
                </div>

                <div class="end">
                    <div class="dropdown">

                        <div class="profile-button">
                            <div class="content">

                                <a id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img
                                        src="https://store.sirclo.com/blog/wp-content/uploads/2022/04/6.-user-persona.jpg" />
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <p class="user">User</p>
                                    <p class="email">user@gmail.com</p>
                                    <hr>
                                    <a class="logout" href="">Logout</a>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            {{-- CONTENT --}}
            <div class="gen-content">
                @yield('content')
            </div>
        </div>



        {{-- <div class="d-flex flex-nowrap " style="max-width: 100%; position: relative;">
            <nav id="sidebar" class="sidebar card py-2" style="min-height: 100vh; ">
                <ul class="nav flex-column " style=" " id="nav_accordion">

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
                            <p
                                class="menu-text {{ in_array(request()->path(), $masterFacility) || $openMasterFacility ? 'fw-bold' : '' }}">
                                Master Data Jenis Sarana
                            </p>
                        </a>
                        <ul
                            class="{{ in_array(request()->path(), $masterFacility) || $openMasterFacility ? '' : 'collapse' }}">
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
                            <p
                                class="menu-text {{ in_array(request()->path(), $masterTrack) || $openMasterTrack ? 'fw-bold' : '' }}">
                                Master Data Perlintasan
                            </p>
                        </a>
                        <ul
                            class="{{ in_array(request()->path(), $masterTrack) || $openMasterTrack ? '' : 'collapse' }}">
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
                        $masterHumanResource = ['sumber-daya-penjaga-jalur-lintasan'];
                        $openMasterHumanResource = false;
                        foreach ($masterHumanResource as $mhr) {
                            if (request()->is($mhr . '*')) {
                                $openMasterHumanResource = true;
                                break;
                            }
                        }
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link menu">
                            <span class="material-symbols-outlined menu-icon">
                                person_apron
                            </span>
                            <p
                                class="menu-text {{ in_array(request()->path(), $masterHumanResource) || $openMasterHumanResource ? 'fw-bold' : '' }}">
                                Master Data SDM
                            </p>
                        </a>
                        <ul
                            class="{{ in_array(request()->path(), $masterHumanResource) || $openMasterHumanResource ? '' : 'collapse' }}">
                            <li class="nav-item">
                                <a class="nav-link menu {{ request()->is('sumber-daya-penjaga-jalur-lintasan*') ? 'active' : '' }}"
                                    href="{{ route('direct-passage-human-resource') }}">
                                    <p class="menu-text">Penjaga Jalur Lintasan</p>
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
                    <li class="nav-item">
                        <a class="nav-link menu {{ request()->is('penjaga-jalur-lintasan*') ? 'active' : '' }}"
                            href="{{ route('direct-passage-guard') }}">
                            <span class="material-symbols-outlined menu-icon">
                                engineering
                            </span>
                            <p class="menu-text">Penjaga Jalur Lintasan (PJL)</p>
                        </a>
                    </li>
                    @php
                        $summary = ['rekapitulasi-sarana', 'rekapitulasi-jalur-perlintasan-langsung', 'rekapitulasi-daerah-rawan-bencana'];
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
                            <li class="nav-item">
                                <a class="nav-link menu {{ request()->is('rekapitulasi-daerah-rawan-bencana*') ? 'active' : '' }}"
                                    href="{{ route('summary-disaster-area') }}">
                                    <p class="menu-text">Daerah Rawan Bencana</p>
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



                </ul>
            </nav>


            <div class="flex-fill p-4" style="max-width: 100% !important; position: relative;  overflow: hidden;">
                @yield('content')
            </div>
        </div> --}}

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/admin-genosstyle.js') }}"></script>
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
