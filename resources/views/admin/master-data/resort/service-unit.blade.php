@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER DATA RESORT</h1>
            <p class="mb-0">Manajemen Data Resort</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('master-data') }}">Master Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Perlintasan</li>
            </ol>
        </nav>
    </div>
        <section class="pt-3">
            <div class="row gx-3">
                @foreach($service_units as $service_unit)
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
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
        var path = '{{ route('resort') }}';
        $(document).ready(function () {
            $('.card-service-unit').on('click', function () {
                let id = this.dataset.id;
                window.location.href = path + '/' + id;
            });
        });
    </script>
@endsection
