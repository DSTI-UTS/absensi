@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Pengabdian</div>

                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('dedication.create') }}" class="btn btn-primary">Tambah Pengabdian</a>
                    </div>
                    <form action="{{ route('dedication.index') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ $search }}">
                            <button class="btn btn-primary" type="submit">Search</button>
                            <a href="{{ url()->current(false, true) }}" class="btn btn-sm btn-outline-warning">Cancel</a>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Funding Source</th>
                                    <th>Funding Amount</th>
                                    <th>Proposal File</th>
                                    <th>Activity Time</th>
                                    <th>Location</th>
                                    <th>Participants</th>
                                    <th>Activity Outcome</th>
                                    <th>Media Publication Outcome</th>
                                    <th>Scientific Publication Outcome</th>
                                    <th>Members</th>
                                    <th>Assignment Letter Link</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dedications as $dedication)
                                <tr>
                                    <td>{{ $dedication->id }}</td>
                                    <td>{{ $dedication->humanResource->sdm_name }}</td>
                                    <td>{{ $dedication->title }}</td>
                                    <td>{{ $dedication->funding_source }}</td>
                                    <td>{{ $dedication->funding_amount }}</td>
                                    <td>
                                        <a href="{{ route('download.pengabdian', ['filename' => base64_encode($dedication->proposal_file)]) }}">File</a>
                                    </td>
                                    <td>{{ $dedication->activity_schedule }}</td>
                                    <td>{{ $dedication->location }}</td>
                                    <td>{{ $dedication->participants }}</td>
                                    <td>{{ $dedication->target_activity_outputs }}</td>
                                    <td>{{ $dedication->public_media_publications }}</td>
                                    <td>{{ $dedication->scientific_publications }}</td>
                                    <td>{{ $dedication->members }}</td>
                                    <td>
                                        <a href="{{ $dedication->assignment_letter_link }}">Link</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('dedication.edit', $dedication->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('dedication.destroy', $dedication->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this dedication?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $dedications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection