@extends('layout.main')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Show data
        </div>
        <div class="card-body">
            <form action="{{ route('index.show', $id->id) }}" method="get" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $id->nama }}" readonly>
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis:</label>
                    <input type="text" class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" value="{{ $id->jenis  }}" readonly>
                    @error('jenis')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="harga_jual">Harga Jual:</label>
                    <input type="text" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{  $id->harga_jual }}" readonly>
                    @error('harga_jual')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="harga_beli">Harga Beli:</label>
                    <input type="text" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" value="{{ $id->harga_beli }}" readonly>
                    @error('harga_beli')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi:</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" readonly>{{ $id->id }}</textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto Produk:</label>
                    <input type="file" class="form-control" id="foto" name="foto" readonly>

                    {{-- @if(!empty($id->foto))
                        <img src="{{url('image')}}/{{$id->foto}}" alt=""class="rounded" style="width: 100%; max-width: 100px; height: auto;">
                    @endif --}}
                    @if(isset($id->foto) && !empty($id->foto))
                    <img src="{{ url('image/' . $id->foto) }}" alt="Foto Produk" class="rounded" style="width: 100%; max-width: 100px; height: auto;">
                    @else
                    <img src="{{ url('image/nophoto.jpg') }}" alt="No Foto" class="rounded" style="width: 100%; max-width: 100px; height: auto;">
                    @endif

                </div>
                <button type="submit" class="btn btn-default mt-4" style="background-color: #f8f9fa; border-color:#ddd; color: #444;">Kembali</button>
            </form>
        </div>
    </div>
</div>
@endsection