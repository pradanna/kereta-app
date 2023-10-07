@extends('layout')

@section('content')
    <form method="post">
        @csrf
        <label for="name">Nama Satuan Pelayanan</label>
        <input type="text" name="name" id="name">
        <button type="submit">Simpan</button>
    </form>
@endsection

@section('js')
@endsection
