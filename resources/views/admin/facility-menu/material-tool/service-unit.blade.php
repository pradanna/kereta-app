@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">ALAT MATERIAL UNTUK SIAGA (AMUS)</h1>
            <p class="mb-0">Manajemen Data Alat Material Untuk Siaga (AMUS)</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('means') }}">Sarana Dan Keselamatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Alat Material Untuk Siaga (AMUS)</li>
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
        var path = '{{ route('means.material-tool') }}';
        let authServiceUnit = '{{ auth()->user()->service_unit_id }}';
        let authRole = '{{ auth()->user()->role }}';
        $(document).ready(function () {
            $('.card-service-unit').on('click', function () {
                let id = this.dataset.id;
                if (authRole !== 'superadmin') {
                    if (authServiceUnit === id) {
                        window.location.href = path + '/' + id;
                    } else {
                        Swal.fire({
                            title: 'Forbidden',
                            text: 'Anda tidak memiliki akses untuk mengakses satuan pelayanan ini...',
                            icon: 'error',
                            timer: 2000
                        })
                    }
                } else {
                    window.location.href = path + '/' + id;
                }
            });
        });
    </script>
@endsection
