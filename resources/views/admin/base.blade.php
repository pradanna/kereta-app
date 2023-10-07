<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yousee || {{ auth()->user()->role }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/appstyle/genosstyle.1.0.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="stylesheet"
        href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /> --}}
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="role" content="{{ auth()->user()->role }}">
    {{-- ICON --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="{{ asset('css/dropify/css/dropify.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
        rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <script src="{{ asset('js/swal.js') }}"></script>

    @yield('css')
</head>

<body>

    <div class="header">
        <div class="header-panel-kiri">
            <a class="btn-icon " onclick="openNav()">
                <span class="material-symbols-outlined">menu
                </span>
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
                <li><a class="dropdown-item disabled" href="#">{{ auth()->user()->email }}</a></li>
                <hr>
                {{-- <li><a class="dropdown-item" href="#">Another action</a></li> --}}
                <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
            </ul>

            </a>


            <ul class="dropdown-menu custom" aria-labelledby="dropdownprofile">
                <li><a class="dropdown-item disabled" href="#">{{ auth()->user()->nama }}</a></li>
                <hr>
                {{-- <li><a class="dropdown-item" href="#">Another action</a></li> --}}
                <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
            </ul>

        </div>

    </div>

    <div class="d-flex">

        {{-- <div class="sidebar"> --}}
        <nav id="sidebar" class="sidebar card py-2" style="height: 100vh;">
            <ul class="nav flex-column" id="nav_accordion">



                {{-- <li class="nav-item">
                <a class="title-role" href="#"> Admin </a>
            </li>
            <li class="nav-item has-submenu">
                <a class="nav-link menu" href="#">
                    <i class="material-symbols-outlined menu-icon">perm_identity</i>
                    <p class="menu-text">Admin</p>
                </a>
                <ul class="submenu  collapse">
                    <li><a class="nav-link menu" href="#"><i class="material-symbols-outlined menu-icon">perm_identity</i>
                            <p class="menu-text">Submenu item 4</p>
                        </a></li>
                    <li><a class="nav-link menu" href="#">
                            <i class="material-symbols-outlined menu-icon">perm_identity</i>
                            <p class="menu-text">Submenu item 4</p>
                        </a></li>
                    <li><a class="nav-link menu" href="#">
                            <i class="material-symbols-outlined menu-icon">perm_identity</i>
                            <p class="menu-text">Submenu item 4</p>
                        </a> </li>
                </ul>
            </li> --}}


                <li class="mt-4 mb-3">
                    <img class="w-100" src="{{ asset('images/local/yousee.png') }}" />
                </li>



                <li class="nav-item">
                    <a class="nav-link menu @if ($sidebar == 'beranda') active @endif " href="/admin">
                        <span class="material-symbols-outlined menu-icon">
                            home
                        </span>
                        <p class="menu-text">Beranda</p>
                    </a>
                </li>
                @if (auth()->user()->role == 'pimpinan')
                    <li class="nav-item">
                        <a class="nav-link menu @if ($sidebar == 'user') active @endif" href="/admin/user">
                            <i class="material-symbols-outlined menu-icon">person</i>
                            <p class="menu-text">User</p>
                        </a>
                    </li>
                @endif




                <li class="nav-item has-submenu">
                    <a class="nav-link menu @if ($sidebar == 'vendor') active @endif" href="/admin/vendor">
                        <i class="material-symbols-outlined menu-icon">handshake</i>
                        <p class="menu-text">Vendor</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu @if ($sidebar == 'tipe') active @endif" href="/admin/type">
                        <i class="material-symbols-outlined menu-icon">open_in_new</i>
                        <p class="menu-text">Tipe Iklan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu @if ($sidebar == 'titik') active @endif" href="/admin/titik">
                        <i class="material-symbols-outlined menu-icon">width_full</i>
                        <p class="menu-text">Titik Iklan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu @if ($sidebar == 'project') active @endif" href="/admin/project">
                        <i class="material-symbols-outlined menu-icon">assignment</i>
                        <p class="menu-text">Project</p>
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


        <div class="w-100 p-4">
            @yield('content')
        </div>
    </div>
    <script>
        var role = '{{ auth()->user()->role }}';
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/base.js') }}"></script>
    <script src="{{ asset('css/dropify/js/dropify.js') }}"></script>

    <script src="{{ asset('js/dialog.js?v=2') }}"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/browser-image-compression@latest/dist/browser-image-compression.js"></script>
    <script src="{{ asset('js/handler_image.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script> --}}
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    {{-- <script src="{{ asset('datatable/datatables.js') }}"></script> --}}

    {{-- <script src="{{ asset('js/datatable.js') }}"></script> --}}

    <script>
        jQuery.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": oSettings._iDisplayLength === -1 ?
                    0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };
    </script>

    @yield('morejs')

</body>

</html>
