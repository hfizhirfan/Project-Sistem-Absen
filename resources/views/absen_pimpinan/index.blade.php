@extends('layouts.abs')

@section('title', 'Halaman Absen')

@section('content')

    <div class="container mt-4">

        @if (session('sudah_absen'))
            {{-- Tampilan setelah absen --}}
            <h3 class="fw-bold" style="margin-bottom: 50px;">Selamat Datang {{ session('nama') }}</h3>
            <p class="fw-semibold" style="font-size: 30px;">Anda telah melakukan absensi</p>
            <p style="font-size: 22px;">Pada {{ session('waktu_absen') }}</p>

            <img src="{{ asset('image/centangijo.png') }}" alt="Gambar Absensi" style="width: 90px; margin-top: 30px;">



            <div class="my-4 text-success" style="font-size: 4rem;">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="custom-button-wrapper">
                <a href="{{ route('karyawan.index') }}" class="custom-rounded-button">
                    Lihat Data Karyawan
                </a>
            </div>




        @else
            {{-- Tampilan form sebelum absen --}}
            <h3 class="fw-bold">Selamat Datang {{ session('nama') ?? 'Pengguna' }}</h3>
            <p class="fw-semibold">Silahkan isi untuk melakukan absensi</p>

            <form action="{{ route('absen.pimpinan.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ session('nip') }}">
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
                        <input type="text" class="form-control" id="jam_absen" name="jam_absen" readonly required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Absen Sekarang</button>
                </div>
            </form>

        @endif
    </div>

@endsection
