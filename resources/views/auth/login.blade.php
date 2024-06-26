<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" href="{{ asset('images/local/favicon.ico') }}" title="Favicon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/appstyle/genosstyle.1.0.css') }}" type="text/css">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    </script>
    <!-- Styles -->
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js') }}"></script>
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body class="w-100 h-100 bg-login">
    <div style="height: 100vh">
        @if (\Illuminate\Support\Facades\Session::has('failed'))
            <script>
                Swal.fire("Autentikasi Gagal ", 'Periksa Username dan Password!', "error")
            </script>
        @endif
        <div class="login">
            <div class="panel-login pinggiran-bunder-10  ">

                <div class="gambar">
                    <img src={{ asset('images/local/kereta.jpg') }} />
                </div>

                <div class="login-container">
                    <div>
                        <p class="text-center mt-3 h2 fw-bold">LOGIN</p>
                        <p class="text-center mt-3 h5 fw-bold">Masukan Username dan Password</p>

                        <form class="p-3" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control login" id="username" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control login" id="password" name="password">
                            </div>
                            <button class="btn-login   mt-4 d-block mb-3 w-100 " type="submit">LOGIN
                            </button>


                        </form>
                    </div>
                    <div>
                        <div class="logo-login">
                            <img src="{{ asset('images/local/logo_btp.png') }}">
                            <img src="{{ asset('images/local/logodishub.png') }}">
                            <img src="{{ asset('images/local/logodjkaw.png') }}">
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('bootstrap/popper.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

</body>

</html>
