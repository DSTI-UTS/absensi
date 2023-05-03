@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ url()->current() }}" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Search...">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                            <a class="btn btn-outline-secondary" href="{{ url()->current(false, false) }}">Cancel</a>
                            <a class="btn btn-outline-primary" href="{{ $exportUrl }}">Download</a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Judul</th>
                                    <th>Lokasi</th>
                                    <th>SK</th>
                                    <th>Sumber dana</th>
                                    <th>Total dana</th>
                                    <th>Tanggal pelaksanaan</th>
                                    <th>Jumlah mahasiswa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offCampusActivities as $index => $offCampusActivity)
                                <tr>
                                    <td>{{ $index + $offCampusActivities->firstItem() }}</td>
                                    <td>{{ $offCampusActivity->sdm_name }}</td>
                                    <td>{{ $offCampusActivity->title }}</td>
                                    <td>{{ $offCampusActivity->location }}</td>
                                    <td>
                                        <a href="{{ route('download.riset', ['filename' => base64_encode($offCampusActivity->performance_certificate)]) }}">File</a>
                                    </td>
                                    <td>{{ $offCampusActivity->budget_source }}</td>
                                    <td>{{ $offCampusActivity->funding_amount }}</td>
                                    <td>{{ $offCampusActivity->execution_date }}</td>
                                    <td>{{ $offCampusActivity->number_of_students }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $offCampusActivities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection