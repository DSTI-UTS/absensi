@extends('layouts.dashboard')

@section('title', 'List Semester')

@section('content')
<div class="container p-5 card">
    <h4 class="mb-4">List Semester</h4>
    <div class="mb-3">
        <a href="{{ route('semester.create') }}">
            <button class="btn btn-sm btn-primary">Tambah Semester</button>
        </a>
    </div>

    <x-success-message />
    <x-table :header="['Semester', 'Aksi']">
        @foreach ($semesters as $semester)
        <tr class="text-capitalize">
            <td>{{ $loop->iteration}}</td>
            <td>{{ $semester->semester }}</td>
            <td>
                @if (auth()->user()->isAdmin())
                <a href="{{ route('semester.edit', $semester->id) }}">Edit</a>
                <x-delete action="{{ route('semester.destroy', $semester->id) }}" confirm="Yakin hapus semester?" />
                @endif
            </td>
        </tr>
        @endforeach
    </x-table>
    <div class="mt-2 float-right">
        {{ $semesters->links() }}
    </div>
</div>
@endsection