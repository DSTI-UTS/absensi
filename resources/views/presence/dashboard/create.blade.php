@extends('layouts.dashboard')

@section('title', 'Tambah Presensi Kehadiran')

@section('content')
<div class="container p-5 card">
    <h4 class="mb-4">Form Presensi Kehadiran</h4>

    <x-form action="{{ route('presence.store') }}" displayError="false">
        <x-select name="sdm_id" label="Dosen" :select="$human_resources" />
        <x-input name="check_in_time" type="datetime-local" label="Jam Masuk" placeholder="Jam Masuk" />
        <x-input name="check_out_time" type="datetime-local" label="Jam Pulang" placeholder="Jam Pulang" />
        <x-input name="latitude_in" type="text" label="Latitude" placeholder="Latitude" />
        <x-input name="longitude_in" type="text" label="Longitude" placeholder="Longitude" />
    </x-form>
</div>
@endsection