<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PT. KAI</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossOrigin="anonymous"/>
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp&display=swap"
        rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/appstyle/genosstyle.1.0.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
    @yield('css')

</head>
<body>
<div class="d-flex flex-column flex-shrink-0 p-3 shadow-sm align-items-center"
     style="width: 280px; border-right: 1px solid rgba(128, 128, 128, .3); height: 100vh; position: fixed">
    <img src="{{ asset('/images/local/logodishub.png') }}" width="100" alt="image-logo">
    <hr>
    <ul>
        <li>
            <a href="#">Dashboard</a>
        </li>
        <li>
            <a href="#">Master Data</a>
            <ul>
                <li>
                    <a href="{{ route('service-unit') }}">Satuan Pelayanan</a>
                </li>
                <li>
                    <a href="{{ route('area') }}">Daerah Operasi</a>
                </li>
                <li>
                    <a href="{{ route('storehouse') }}">Depo dan Balai Yasa</a>
                </li>
            </ul>

        </li>
    </ul>
</div>

<div class="w-100 d-flex flex-column" style="min-height: 100vh; padding-left: 280px;">

    <div class="shadow-sm" style="height: 3rem"></div>
    <div class="" style="padding: 20px 20px">
        @yield('content')
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@yield('js')
</body>
</html>
