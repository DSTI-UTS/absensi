@extends('layouts.dashboard')

@section('title', 'List Jadwal Pertemuan')

@section('content')
<div class="container p-5 card">
    <h4 class="mb-4">List jadwal pertemuan: {{ $subject->subject }} ({{ $subject->sks}} SKS)</h4>
    <x-success-message />
    @php
    $action = collect(['Pertemuan' , 'Tanggal', 'Jam Dimulai', 'Foto', 'Link']);
    if(auth()->user()->isStudyProgram()){
    $action->push('Aksi');
    }
    @endphp
    <x-table :header="$action">
        @foreach ($meetings as $meeting)
        <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $meeting->meeting_name }}</td>
            <td>{{ $meeting->date }}</td>
            <td>{{ $meeting->meeting_start }}</td>
            <td>
                @if ($meeting->file)
                <a href="#{{ $meeting->file }}">Foto</a>
                @endif
            </td>
            <td>
                @if ($meeting->url)
                {{$meeting->url->link}}
                @endif
            </td>
            @if (auth()->user()->isStudyProgram())
            <td>
                <a href="{{ route('meeting.edit', $meeting->id) }}">Edit</a>
                <x-delete action="{{ route('meeting.destroy', $meeting->id) }}" />
            </td>
            @endif
        </tr>
        @endforeach
    </x-table>
</div>
@endsection