@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">KESELAMATAN DAN KESEHATAN KERJA (K3)</h1>
            <p class="mb-0">Manajemen Data Keselamatan dan Kesehatan Kerja (K3)</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Keselamatan dan Kesehatan Kerja (K3)</li>
            </ol>
        </nav>
    </div>
    <section class="pt-3">
        <div class="row gx-3">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                <div class="card-service-unit" data-id="monitoring-implementasi-k3">
                    <span>Monitoring Implementasi K3</span>
                    <span class="material-symbols-outlined">chevron_right</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mb-3">
                <div class="card-service-unit" data-id="laporan-bulanan-k3l">
                    <span>Laporan Bulanan K3L</span>
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
        var path = '{{ route('means.work-safety') }}';
        $(document).ready(function () {
            $('.card-service-unit').on('click', function () {
                let id = this.dataset.id;
                window.location.href = path + '/' + id;
            });
        });
    </script>
@endsection
