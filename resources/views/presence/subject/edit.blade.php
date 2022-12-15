@extends('layouts.dashboard')

@section('title', 'Edit Program Studi')

@section('content')
<div class="container p-5 card">
    <h4 class="mb-4">Form edit program studi</h4>

    <x-form action="{{ route('subject.update', $subject->id) }}" displayError="true">
        @method('PUT')
        <x-input name="subject" label="Mata Kuliah" placeholder="Mata Kuliah" :value="$subject->subject" />
        <x-input name="sks" label="Jumlah SKS" placeholder="Jumlah SKS" :value="$subject->sks" />
        <x-input name="number_of_meetings" label="Jumlah Pertemuan" placeholder="Jumlah Pertemuan" :value="$subject->number_of_meetings" />
        <x-select name="study_program_id" label="Program Studi" :select="$study_programs" :current="$subject->study_program_id" />
        <x-select name="sdm_id" label="Dosen" :select="$human_resources" :current="$subject->sdm_id" />
    </x-form>
</div>
@endsection