@extends('layout')

@section('content')
    <form method="post">
        @csrf
        <label for="area">Daerah Operasi : </label>
        <select name="area" id="area">
            @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
        </select>
        <br>
        <label for="storehouse_type">Tipe Depo / Balai Yasa : </label>
        <select name="storehouse_type" id="storehouse_type">
            @foreach($storehouse_types as $storehouse_type)
                <option value="{{ $storehouse_type->id }}">{{ $storehouse_type->name }}</option>
            @endforeach
        </select>
        <br>
        <label for="city">Kota : </label>
        <select name="city" id="city">
            @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
        <br>
        <label for="name">Nama Depo / Balai Yasa</label>
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
