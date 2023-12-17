@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SARANA DAN KESELAMATAN PERKERETAAPIAN</h1>
            <p class="mb-0">Manajemen Data Sarana Dan Keselamatan Perkeretaapian</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sarana Dan Keselamatan</li>
            </ol>
        </nav>
    </div>
{{--    <section class="pt-5">--}}
{{--        <div class="row gx-3">--}}
{{--            @foreach($service_units as $service_unit)--}}
{{--                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">--}}
{{--                    <div class="card-service-unit" data-id="{{ $service_unit->id }}">--}}
{{--                        <span>{{ $service_unit->name }}</span>--}}
{{--                        <span class="material-symbols-outlined">chevron_right</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </section>--}}
    <section class="pt-3">
        <div class="row gx-3">
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="sertifikasi-sarana">
                    <span class="material-symbols-outlined">train</span>
                    <span class="text-center">Sertifikasi Sarana</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="depo-dan-balai-yasa">
                    <span class="material-symbols-outlined">store</span>
                    <span class="text-center">Depo Dan Balai Yasa</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="spesifikasi-teknis">
                    <span class="material-symbols-outlined">manufacturing</span>
                    <span class="text-center">Spesifikasi Teknis</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="jalur-perlintasan-langsung">
                    <span class="material-symbols-outlined">timeline</span>
                    <span class="text-center">Perlintasan Kereta Api (JPL)</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="daerah-rawan-bencana">
                    <span class="material-symbols-outlined">flood</span>
                    <span class="text-center">IDRK (Daerah Rawan)</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="peristiwa-luar-biasa-hebat">
                    <span class="material-symbols-outlined">car_crash</span>
                    <span class="text-center">Peristiwa Luar Biasa Hebat</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="amus">
                    <span class="material-symbols-outlined">carpenter</span>
                    <span class="text-center">Alat Material Untuk Siaga (AMUS)</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="bangunan-liar">
                    <span class="material-symbols-outlined">home_work</span>
                    <span class="text-center">Bangunan Liar</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="keselamatan-dan-kesehatan-kerja">
                    <span class="material-symbols-outlined">health_and_safety</span>
                    <span class="text-center">Keselamatan Dan Kesehatan Kerja</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="sumber-daya-manusia">
                    <span class="material-symbols-outlined">engineering</span>
                    <span class="text-center">SDM</span>
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
        var path = '{{ route('means') }}';
        $(document).ready(function () {
            $('.card-menu').on('click', function () {
                let slug = this.dataset.slug;
                window.location.href = path + '/' + slug;
            });
        });
    </script>
@endsection
