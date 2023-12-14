@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA</h1>
            <p class="mb-0">Manajemen Data Spesifikasi Teknis Sarana</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Spesifikasi Teknis Sarana</li>
            </ol>
        </nav>
    </div>
    <section class="pt-3">
        <div class="row gx-3">
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-3">
                <div class="card-service-unit" data-slug="lokomotif">
                    <span>Lokomotif</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-3">
                <div class="card-service-unit" data-slug="kereta">
                    <span>Kereta</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-3">
                <div class="card-service-unit" data-slug="gerbong">
                    <span>Gerbong</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 mb-3">
                <div class="card-service-unit" data-slug="peralatan-khusus">
                    <span>Peralatan Khusus</span>
                    <span class="material-symbols-outlined">chevron_right</span>
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
        let currentPath = '/{{ request()->path() }}';
        $(document).ready(function () {
            $('.card-service-unit').on('click', function () {
                let slug = this.dataset.slug;
                window.location.href = currentPath + '/' + slug;
            });
        });
    </script>
@endsection
