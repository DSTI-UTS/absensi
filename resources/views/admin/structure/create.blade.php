@extends('layouts.dashboard')

@section('title', 'Tambah Jabatan Struktural')

@section('content')
<div class="container p-5 card">
    <h4 class="mb-4">Form jabatan struktural</h4>
    <x-form action="{{ route('structure.store') }}" displayError="false">
        <x-select name="parent_id" label="Pilih top level" :select="$parent" />
        <x-select name="type" label="Pilih tipe" :select="$types" />
        <x-input name="role" label="Jabatan" placeholder="Nama jabatan" />
    </x-form>
</div>
@endsection