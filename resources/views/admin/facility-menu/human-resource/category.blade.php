@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SUMBER DAYA MANUSIA</h1>
            <p class="mb-0">Manajemen Data Sumber Daya Manusia</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sumber Daya Manusia</li>
            </ol>
        </nav>
    </div>
    <section class="pt-3">
        <div class="row gx-3">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="ppka">
                    <span>PPKA</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="awak-sarana-perkeretaapian">
                    <span>Awak Sarana Perkeretaapian</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="pemeriksa-sarana">
                    <span>Pemeriksa Sarana</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="perawat-sarana">
                    <span>Perawat Sarana</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                <div class="card-service-unit" data-slug="penjaga-perlintasan">
                    <span>Penjaga Perlintasan Kereta Api (PJL)</span>
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
        var path = '/{{ request()->path() }}';
        $(document).ready(function () {
            $('.card-service-unit').on('click', function () {
                let slug = this.dataset.slug;
                window.location.href = path + '/' + slug;
            });
        });
    </script>
@endsection
