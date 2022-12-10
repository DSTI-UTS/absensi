@extends('layouts.dashboard')

@section('title', 'Tambah Kelas')

@section('content')
<div class="container p-5 card">
    <h4 class="mb-4">List kelas</h4>
    <div class="mb-3">
        <a href="{{ route('class.create') }}">
            <button class="btn btn-sm btn-primary">Tambah kelas</button>
        </a>
    </div>

    <x-success-message />
    <x-table :header="['Kelas', 'Prodi', 'Aksi']">
        @foreach ($classes as $class)
        <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $class->class }}</td>
            <!-- agar admin dapat list kelas masing2 prodi saat tambah jadwal kuliah -->
            <td>{{ $class->study_program->study_program }}</td>
            <td>
                <a href="{{ route('class.edit', $class->id) }}">Edit</a>
                <x-delete action="{{ route('class.destroy', $class->id) }}" confirm="Yakin hapus {{ $class->class }}" />
            </td>
        </tr>
        @endforeach
    </x-table>
    <div class="mt-2 float-right">
        {{ $classes->links() }}
    </div>
</div>
@endsection