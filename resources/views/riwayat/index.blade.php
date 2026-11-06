@extends('layouts.app')

@section('title', 'Halaman Pengajuan Cuti')

@section('content')

    <!-- Form -->
    <div class="container mt-5">
        <h4 class="mb-1 fw-bold">Riwayat Pengajuan</h4>

        <p class="mb-3"><strong>{{ session('nama') }}</strong> ({{ session('nip') }})</p>


        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('absen.create') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>




        <div class="card mb-4">
            <div class="card-body">


                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Jenis Laporan</th>
                            <th>Status</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayats as $riwayat)
                            <tr>
                                <td>{{ ucfirst($riwayat->jenis_laporan) }}</td>
                                <td>{{ ucfirst($riwayat->status) }}</td>
                                <td>{{ $riwayat->nip }}</td>
                                <td>{{ $riwayat->nama }}</td>
                                <td>{{ $riwayat->jabatan }}</td>
                                <td>{{ $riwayat->divisi }}</td>
                                <td>{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada riwayat laporan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection


