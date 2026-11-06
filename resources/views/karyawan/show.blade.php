@extends('layout.main')
@section('content')
<div class="container-fluid mt-4 ps-4">
    <h3 class="mb-5">Detail Karyawan</h3>
    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text"
                class="form-control w-50 @error('nip') is-invalid @enderror"
                id="nip" name="nip"
                value="{{ $karyawan->nip }}"
                readonly>
            @error('nip')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text"
                class="form-control w-50 @error('nama') is-invalid @enderror"
                id="nama" name="nama"
                value="{{ $karyawan->nama }}"
                readonly>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text"
                class="form-control w-50 @error('jabatan') is-invalid @enderror"
                id="jabatan" name="jabatan"
                value="{{ $karyawan->jabatan }}"
                readonly>
            @error('jabatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="divisi" class="form-label">Divisi</label>
            <input type="text"
                class="form-control w-50 @error('divisi') is-invalid @enderror"
                id="divisi" name="divisi"
                value="{{ $karyawan->divisi }}"
                readonly>
            @error('divisi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <p class="form-control-plaintext text-muted w-50" id="password-placeholder">**********</p>
        </div>

       <a href="{{ route('karyawan.index') }}" class="btn btn-secondary mt-2">Back</a>

    </form>
</div>


     <script>
        document.addEventListener("DOMContentLoaded", function () {
            const nama = "{{ strtolower($karyawan->nama) }}";
            const nip = "{{ $karyawan->nip }}";
            const password = nama + nip.slice(-3);
            document.getElementById("password-placeholder").innerText = password;
        });
    </script>
@endsection
