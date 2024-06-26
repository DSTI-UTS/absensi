@extends('layouts.dashboard')

@section('title', 'Title')

@section('content')
    <div class="container card p-2">
        <table class="table table-bordered">
            <tr>
                <td>Jenis Test</td>
                <td>{{ $data['jenis_tes'] }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $data['nama'] }}</td>
            </tr>
            <tr>
                <td>Penyelenggara</td>
                <td>{{ $data['penyelenggara'] }}</td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td>{{ $data['tahun'] }}</td>
            </tr>
            <tr>
                <td>Skor</td>
                <td>{{ $data['skor'] }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>{{ $data['tanggal'] }}</td>
            </tr>
            <x-dokumen :document="$data['dokumen']"></x-dokumen>
        </table>
    </div>
@endsection
