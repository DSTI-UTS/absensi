@extends('layouts.dashboard')
@section('title', 'Presence')

@section('content')
<div class="container p-5 card">
    <h4 class="mb-4">List Absensi Kehadiran</h4>
    @if (url()->current() == route('presence.my-presence'))
    <div class="mb-4">
        <a href="{{ route('presence.absen') }}" class="btn btn-primary btn-block">Input izin</a>
        <a href="{{ route('presence.my-absen') }}" class="btn btn-primary btn-block">List izin</a>
    </div>
    @endif

    <x-success-message />
    <x-error-message />

    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="font-weight: bolder; color: black;">Total jam</th>
                    <th style="font-weight: bolder; color: black;">{{ $hours->effective_hours }}</th>
                </tr>
            </thead>
        </table>
    </div>

    <x-search-presence withDate="{{ $withDate ?? false }}" exportUrl="{{ $exportUrl ?? false }}" />
    <x-table :header="['Nama', 'NIDN', 'Jabatan', 'Tanggal', 'Jam Masuk', 'Jam Pulang', 'Jam Efektif']">
        @foreach ($presences as $index => $presence)
        <tr>
            <td>{{ $index + $presences->firstItem() }}</td>
            <td>{{ $presence->sdm_name }}</td>
            <td>{{ $presence->nidn }}</td>
            <td>{{ $presence->roles() }}</td>
            <td>{{ $presence->check_in_date != NULL ? $presence->check_in_date : Carbon\Carbon::parse($presence->created_at)->locale('id')->dayName }}</td>
            <td>{{ $presence->check_in_hour }}</td>
            <td>{{ $presence->check_out_hour }}</td>
            <td>{{ $presence->effective_hours }}</td>
        </tr>
        @endforeach
    </x-table>
    <div class="mt-2 float-right">
        {{ $presences->links() }}
    </div>
</div>
@endsection