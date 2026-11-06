@extends('layout.main')
@section('content')
<div class="container-fluid mt-4 ps-4">
    <h3 class="mb-5">Edit Karyawan</h3>
    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text"
                class="form-control w-50 @error('nip') is-invalid @enderror"
                id="nip" name="nip"
                value="{{ old('nip', $karyawan->nip) }}"
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
                value="{{ old('nama', $karyawan->nama) }}">
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text"
                class="form-control w-50 @error('jabatan') is-invalid @enderror"
                id="jabatan" name="jabatan"
                value="{{ old('jabatan', $karyawan->jabatan) }}">
            @error('jabatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="divisi" class="form-label">Divisi</label>
            <input type="text"
                class="form-control w-50 @error('divisi') is-invalid @enderror"
                id="divisi" name="divisi"
                value="{{ old('divisi', $karyawan->divisi) }}">
            @error('divisi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
</div>


@endsection
