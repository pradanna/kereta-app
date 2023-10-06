@extends('layout')

@section('content')
    <form method="post">
        @csrf
        <label for="service_unit">Satuan Pelayanan : </label>
        <select name="service_unit" id="service_unit">
            @foreach($service_units as $service_unit)
                <option value="{{ $service_unit->id }}">{{ $service_unit->name }}</option>
            @endforeach
        </select>
        <br>
        <label for="name">Nama Daerah Operasi</label>
        <input type="text" name="name" id="name">
        <br>
        <label for="latitude">Latitude</label>
        <input type="number" name="latitude" id="latitude" step="any">
        <br>
        <label for="longitude">Longitude</label>
        <input type="number" name="longitude" id="longitude" step="any">
        <br>
        <button type="submit">Simpan</button>
    </form>
@endsection
