@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER DATA</h1>
            <p class="mb-0">Manajemen Data Master Data</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">Master Data</li>
            </ol>
        </nav>
    </div>
    <section class="pt-3">
        <div class="row gx-3">
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="kecamatan">
                    <span>Kecamatan</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="jenis-lokomotif">
                    <span>Jenis Lokomotif</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="jenis-kereta">
                    <span>Jenis Kereta</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="jenis-gerbong">
                    <span>Jenis Gerbong</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="sub-jenis-gerbong">
                    <span>Sub Jenis Gerbong</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="jenis-peralatan-khusus">
                    <span>Jenis Peralatan Khusus</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="perlintasan">
                    <span>Lintasan</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="petak">
                    <span>Petak</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="jenis-rawan-bencana">
                    <span>Jenis Rawan Bencana</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="resort">
                    <span>Resort</span>
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
        var path = '{{ route('master-data') }}';
        $(document).ready(function () {
            $('.card-service-unit').on('click', function () {
                let slug = this.dataset.slug;
                window.location.href = path + '/' + slug;
            });
        });
    </script>
@endsection
