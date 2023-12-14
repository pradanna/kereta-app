@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">LALU LINTAS DAN ANGKUTAN KERETA API</h1>
            <p class="mb-0">Manajemen Data Lalu Lintas Dan Angkutan Kereta Api</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lalu Lintas Dan Angkutan Kereta Api</li>
            </ol>
        </nav>
    </div>
    <section class="pt-3">
        <div class="row gx-3 justify-content-center">
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="stasiun-kereta-api">
                    <span class="material-symbols-outlined">directions_railway</span>
                    <span class="text-center">Stasiun Kereta Api</span>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '{{ route('traffic') }}';
        $(document).ready(function () {
            $('.card-menu').on('click', function () {
                let slug = this.dataset.slug;
                window.location.href = path + '/' + slug;
            });
        });
    </script>
@endsection
