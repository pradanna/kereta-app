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
        <div class="row gx-3 justify-content-start ">
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                <div class="card-menu" data-slug="safety-assessment">
                    <span class="spanmenu"><img class="icon-menu"
                            src="{{ asset('images/local/prasarana/health.png') }}" /></span>
                    <span class="text-center text-menu">Safety Assessment</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                <div class="card-menu" data-slug="jembatan-penyebrangan">
                    <span class="spanmenu"><img class="icon-menu"
                            src="{{ asset('images/local/prasarana/overpass.png') }}" /></span>
                    <span class="text-center text-menu">Jembatan Penyebrangan<br> (JPOM, Underpass, Flyover)</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                <div class="card-menu" data-slug="permohonan-izin-melintas-rel">
                    <span class="spanmenu"><img class="icon-menu"
                            src="{{ asset('images/local/prasarana/approval.png') }}" /></span>
                    <span class="text-center text-menu">Permohonan Izin Melintas Rel (Crossing)</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                <div class="card-menu" data-slug="jembatan-kereta-api">
                    <span class="spanmenu"><img class="icon-menu"
                            src="{{ asset('images/local/prasarana/railway.png') }}" /></span>
                    <span class="text-center text-menu">Jembatan Kereta Api (BH)</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}" />
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
    <script>
        var path = '{{ route('infrastructure') }}';
        $(document).ready(function() {
            $('.card-menu').on('click', function() {
                let slug = this.dataset.slug;
                window.location.href = path + '/' + slug;
            });
        });
    </script>
@endsection
