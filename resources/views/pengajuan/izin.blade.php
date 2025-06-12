@extends('layouts.app')

@section('title', 'Halaman Absen')

@section('content')

    <div class="container mt-5">
        <h4 class="mb-1 fw-bold">Form Pengajuan Izin</h4>
        <p class="mb-4 fw-semibold">Silahkan isi untuk pengajuan</p>

        <form action="{{ route('pengajuan.izin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ session('nip') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ session('jabatan') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_cuti" class="form-label">Tanggal Izin</label>
                        <input type="date" class="form-control" id="tanggal_cuti" name="tanggal_cuti" required>
                    </div>
                </div>
                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="divisi" class="form-label">Divisi</label>
                        <input type="text" class="form-control" id="divisi" name="divisi" value="{{ session('divisi') }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bukti" class="form-label">Bukti Surat Dokter</label>
                    <input type="file" class="form-control" id="bukti" name="bukti" accept=".jpg,.jpeg,.png" required>
                </div>


                <div class="col-12">
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Isi keterangan" required></textarea>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 me-2">Kirim Pengajuan</button>
                    <button type="button" onclick="window.location='{{ route('absen.create') }}'" class="btn btn-danger rounded-pill px-4">Batal</button>
                </div>
            </div>
        </form>
    </div>
@endsection
