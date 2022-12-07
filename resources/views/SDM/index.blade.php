@extends('layout.dashboard')

@section('title', 'Dashboard BKD')

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Daftar SDM Universitas Teknologi Sumbawa</h6>
                    <p class="text-muted mb-3">
                        Klik "Pilih sdm" untuk melihat detail sdm.
                    </p>

                    <b>
                        ID SDM: {{ session('id_sdm') }} <br>
                        Nama SDM: {{ session('nama_sdm') }} <br>
                        <!-- token: {{ session('token') }} -->
                    </b>
                    <form action="/" class="row mt-3">
                        <div class="col-10">
                            <label for="nama" class="visually-hidden">Password</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Cari nama SDM" autocomplete="off">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Cari</button>
                        </div>
                        <div class="col-auto">
                            <a href="/"><button type="submit" class="btn btn-danger mb-3">Reset</button></a>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>ID</th>
                                    <th>NIDN</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sdm as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $item->nama_sdm }}</td>
                                        <td>{{ $item->id_sdm }}</td>
                                        <td>{{ $item->nidn }}</td>
                                        <td>
                                            <a
                                                href="{{ route('bkd.set-sdm', ['id_sdm' => $item->id_sdm, 'nama_sdm' => $item->nama_sdm]) }}">
                                                <button class="btn btn-sm btn-success">Pilih SDM</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-2 float-right">
                            {{ $sdm->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
