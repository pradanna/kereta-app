@extends('admin.base')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div class="page-title-container">
            <h1 class="h1">SPESIFIKASI TEKNIS SARANA LOKOMOTIF</h1>
            <p class="mb-0">Manajemen Data Dokumen Spesifikasi Teknis Sarana Lokomotif</p>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('technical-specification.locomotive') }}">Spesifikasi
                        Teknis Sarana Lokomotif</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data->locomotive_type->code }}</li>
            </ol>
        </nav>
    </div>
    <div class="panel">
        <div class="title">
            <p>Form Data Spesifikasi Teknis Sarana Lokomotif</p>
        </div>
        <div class="isi">
            <form action="/file-upload"
                  class="dropzone"
                  id="my-great-dropzone"></form>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('/css/custom-style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('/css/dropzone.min.css') }}" rel="stylesheet"/>

@endsection

@section('js')
    <script src="{{ asset('/js/dropzone.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function () {

            $("#my-great-dropzone").dropzone({
                addRemoveLinks: true,
                autoProcessQueue: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",

                },
            });
        });
    </script>
@endsection

