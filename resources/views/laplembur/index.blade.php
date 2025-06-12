@extends('layout.main')
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Laporan Lembur</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Laporan Lembur</li>
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
                        <th>Tanggal Lembur</th>
                        <th>Status</th>
                        <th width="180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laplemburs as $item)
                    <tr>
                        <td>{{ $item->nip }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->divisi }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lembur)->format('d-m-Y') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a href="{{ route('laplembur.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-circle-info"></i> Selengkapnya
                            </a>

                            {{-- Tampilkan tombol acc hanya jika role sesuai dan status match --}}
                            @if (session('role') === 'kepala_divisi' && $item->status === 'Menunggu Kadiv')
                                <form action="{{ route('laplembur.accKadiv', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm mt-1">
                                        <i class="fa-solid fa-check"></i> Acc Kadiv
                                    </button>
                                </form>
                            @elseif (session('role') === 'direktur' && $item->status === 'Disetujui Kadiv')
                                <form action="{{ route('laplembur.accDirektur', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm mt-1">
                                        <i class="fa-solid fa-check"></i> Acc Direktur
                                    </button>
                                </form>
                            @endif

                            {{-- Tombol hapus hanya jika user bukan direktur --}}
                            @if (!in_array(session('role'), ['direktur', 'kepala_divisi']))
                            <button type="button" class="btn btn-danger btn-sm mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                            @endif

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Hapus Laporan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Yakin ingin menghapus lembur <strong>{{ $item->nama }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('laplembur.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End Modal --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($laplemburs->isEmpty())
                <p class="text-center mt-3">Belum ada laporan lembur.</p>
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
