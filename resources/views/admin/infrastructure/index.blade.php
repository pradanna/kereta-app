@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">PRASARANA PERKERETAAPIAN</h1>
            <p class="mb-0">Manajemen Data Prasarana Perkeretaapian</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Prasarana</li>
            </ol>
        </nav>
    </div>
    <section class="pt-3">
        <div class="row gx-3 justify-content-center">
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="safety-assessment">
                    <span class="material-symbols-outlined">health_and_safety</span>
                    <span class="text-center">Safety Assessment</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="jembatan-penyebrangan">
                    <span class="material-symbols-outlined">fort</span>
                    <span class="text-center">Jembatan Penyebrangan (JPOM, Underpass, Flyover)</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="permohonan-izin-melintas-rel">
                    <span class="material-symbols-outlined">vpn_key</span>
                    <span class="text-center">Permohonan Izin Melintas Rel (Crossing)</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2 col-xl-2 mb-3">
                <div class="card-menu" data-slug="jembatan-kereta-api">
                    <span class="material-symbols-outlined">timeline</span>
                    <span class="text-center">Jembatan Kereta Api (BH)</span>
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
        var path = '{{ route('infrastructure') }}';
        $(document).ready(function () {
            $('.card-menu').on('click', function () {
                let slug = this.dataset.slug;
                window.location.href = path + '/' + slug;
            });
        });
    </script>
@endsection
