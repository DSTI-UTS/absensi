@extends('layouts.dashboard')

@section('title', 'BKD')

@section('content')
<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    List
                </div>
                <h2 class="page-title">
                    {{ __('Bkd ') }}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('bkds.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Create Bkd
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bkd</h3>
                    </div>
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                            <div class="text-muted">
                                Show
                                <div class="mx-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm" value="10" size="3" aria-label="Invoices count">
                                </div>
                                entries
                            </div>
                            <div class="ms-auto text-muted">
                                Search:
                                <div class="ms-2 d-inline-block">
                                    <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th class="w-1">No.</th>
                                    <th>Nama Dosen</th>
                                    <th>NIDN</th>
                                    <th>Periode</th>
                                    <th>Ab</th>
                                    <th>C</th>
                                    <th>D</th>
                                    <th>E</th>
                                    <th>Total</th>
                                    <th>Kesimpulan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bkds as $bkd)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $bkd->sdm->sdm_name }}</td>
                                    <td>{{ $bkd->sdm->nidn }}</td>
                                    <td>{{ $bkd->period }}</td>
                                    <td>{{ $bkd->ab }}</td>
                                    <td>{{ $bkd->c }}</td>
                                    <td>{{ $bkd->d }}</td>
                                    <td>{{ $bkd->e }}</td>
                                    <td>{{ $bkd->total }}</td>
                                    <td>{{ $bkd->summary }}</td>

                                    <td class="">
                                        <a class="btn btn-sm btn-primary" href="{{ route('sub.profile',$bkd->sdm->sdm_id) }}">
                                            Profile Dosen
                                        </a>
                                        <a class="btn btn-sm btn-warning" href="{{ route('bkds.edit',$bkd->id) }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('bkds.destroy',$bkd->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="if(!confirm('Do you Want to Proceed?')){return false;}">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <td>No Data Found</td>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        {!! $bkds->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection