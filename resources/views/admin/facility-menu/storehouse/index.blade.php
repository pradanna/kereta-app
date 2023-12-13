@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">DEPO DAN BALAI YASA</h1>
            <p class="mb-0">Manajemen Data Depo Dan Balai Yasa</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('infrastructure') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Depo Dan Balai Yasa</li>
            </ol>
        </nav>
    </div>
        <section class="pt-5">
            <div class="row gx-3">
                @foreach($service_units as $service_unit)
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-3">
                        <div class="card-service-unit" data-id="{{ $service_unit->id }}">
                            <span>{{ $service_unit->name }}</span>
                            <span class="material-symbols-outlined">chevron_right</span>
                        </div>
                    </div>
                @endforeach
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
