@extends('layout.main')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Cuti Karyawan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Laporan Cuti Karyawan</li>
    </ol>
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
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Tanggal Izin</th>
                        <th>Status</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lapcutis as $item)
                    <tr>
                        <td>{{ $item->nip }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->divisi }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_izin)->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
                            <a href="{{ route('lapcuti.edit', $item->id) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-circle-info"></i> Selengkapnya</a>

                            {{-- Tombol hapus hanya jika user bukan direktur atau kepala_divisi --}}
                            @if (!in_array(session('role'), ['direktur', 'kepala_divisi']))
                                <button type="button" class="btn btn-danger btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>

                                <!-- Modal Delete Confirmation -->
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Hapus Data Izin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data izin dari <strong>{{ $item->nama }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('lapcuti.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($lapcutis->isEmpty())
                <p class="text-center mt-3">Belum ada data izin.</p>
            @endif
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
