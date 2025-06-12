@extends('layout.main')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="card mb-4">

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <table id="datatablesSimple">
                <thead>
                    <tr>

                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Jam Absen</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ( $lapabsen as $k )
                    <tr>

                        <td>{{ $k->nip }}</td>
                        <td>{{ $k->nama }}</td>
                        <td>{{ $k->jabatan }}</td>
                        <td>{{ $k->divisi }}</td>
                        <td>{{ $k->jam_absen }}</td>

                        <td>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{$k->id}}">
                            hapus
                        </button>

                        <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$k->id}}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $k->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="deleteModalLabel{{ $k->id }}">Hapus Produk</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin akan menghapus data {{$k->nama}}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                            <form action="{{ route('lapabsen.destroy', $k->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                // Tambahkan efek fade out secara manual
                alert.classList.remove('show');
                alert.classList.add('fade');

                // Tunggu sebentar lalu hapus dari DOM
                setTimeout(() => {
                    alert.remove();
                }, 300); // 300ms agar animasi fade out selesai
            }, 2000); // Tampilkan selama 2 detik
        }
    });
</script>
@endsection
