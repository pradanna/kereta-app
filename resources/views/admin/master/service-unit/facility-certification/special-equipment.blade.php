@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">MASTER SATUAN PELAYANAN</h1>
            <p class="mb-0">Manajemen Data Master Satuan Pelayanan</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('service-unit') }}">Satuan Pelayanan</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('service-unit.facility-certification', ['id' => $data->id]) }}">Sertifikasi Sarana</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Peralatan Khusus</li>
            </ol>
        </nav>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/custom-style.css') }}"/>
@endsection

@section('js')
    <script src="{{ asset('js/helper.js') }}"></script>
@endsection
