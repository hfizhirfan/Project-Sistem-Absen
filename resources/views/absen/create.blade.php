@extends('layouts.app')

@section('title', 'Halaman Absen')

@section('content')

    <div class="container mt-4">
        @if (session('sudah_absen'))
            <h3 class="fw-bold mb-4">Selamat Datang {{ session('nama') }}</h3>
            <p class="fw-semibold fs-4">Anda telah melakukan absensi</p>
            <p class="fs-5">Pada {{ session('waktu_absen') }}</p>
            <img src="{{ asset('image/centangijo.png') }}" alt="Absen Berhasil" style="width: 90px; margin-top: 30px;">
            <hr>
            <p class="fw-semibold">Silahkan pilih salah satu untuk pengajuan</p>
            <div class="d-flex gap-2 pengajuan-group">
                <a href="{{ route('pengajuan.lembur') }}" class="btn btn-lembur active-btn" id="btn-lembur">Lembur</a>
                <a href="{{ route('pengajuan.cuti') }}" class="btn btn-cuti" id="btn-cuti">Cuti</a>
                <a href="{{ route('pengajuan.izin') }}" class="btn btn-izin" id="btn-izin">Izin</a>
            </div>
        @else
            <h3 class="fw-bold">Selamat Datang {{ session('nama') ?? 'Pengguna' }}</h3>
            <p class="fw-semibold">Silahkan isi untuk melakukan absensi</p>

            <form action="{{ route('absen.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- input form isi seperti sebelumnya -->
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ session('nip') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ session('jabatan') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="divisi" class="form-label">Divisi</label>
                        <input type="text" class="form-control" id="divisi" name="divisi" value="{{ session('divisi') }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="jam_absen" class="form-label">Jam Absen</label>
                        <input type="datetime-local" class="form-control" id="jam_absen" name="jam_absen" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Absen Sekarang</button>
                </div>
            </form>

            <hr>
            <p class="fw-semibold">Silahkan pilih salah satu untuk pengajuan</p>
            <div class="d-flex gap-2 pengajuan-group">
                <a href="{{ route('pengajuan.lembur') }}" class="btn btn-lembur active-btn" id="btn-lembur">Lembur</a>
                <a href="{{ route('pengajuan.cuti') }}" class="btn btn-cuti" id="btn-cuti">Cuti</a>
                <a href="{{ route('pengajuan.izin') }}" class="btn btn-izin" id="btn-izin">Izin</a>
            </div>
        @endif
    </div>


@endsection
