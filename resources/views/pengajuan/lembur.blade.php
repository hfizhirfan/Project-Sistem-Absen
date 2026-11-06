@extends('layouts.app')

@section('title', 'Halaman Pengajuan Lembur')

@section('content')
    <div class="container mt-5 mb-5">
        <h4 class="mb-1 fw-bold">Form Pengajuan Lembur</h4>
        <p class="mb-4 fw-semibold">Silahkan isi untuk pengajuan</p>

        <form action="{{ route('pengajuan.lembur.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" value="{{ session('nip') }}">
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ session('jabatan') }}">
                </div>
                <div class="mb-3">
                    <label for="tanggal_lembur" class="form-label">Tanggal Lembur</label>
                    <input type="date" class="form-control" id="tanggal_lembur" name="tanggal_lembur" required>
                </div>
                <div class="mb-3">
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                </div>
                <div class="mb-3">
                    <label for="durasi" class="form-label">Durasi</label>
                    <input type="text" class="form-control" id="durasi" name="durasi" placeholder="Contoh : 2 Jam" required>
                </div>
            </div>


            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}">
                </div>

                <div class="mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <input type="text" class="form-control" id="divisi" name="divisi" value="{{ session('divisi') }}">
                </div>

                 <div class="mb-3 invisible">
                    <label class="form-label">&nbsp;</label>
                    <input type="text" class="form-control" disabled style="opacity: 0;">
                 </div>

                 <div class="mb-3">
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                </div>

            </div>


            <div class="col-12">
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Isi keterangan"></textarea>
            </div>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary rounded-pill px-4 me-2">Kirim Pengajuan</button>
                <button type="button" onclick="window.location='{{ route('absen.create') }}'" class="btn btn-danger rounded-pill px-4">
                    Batal
                </button>

            </div>
        </div>
        </form>
    </div>
@endsection
