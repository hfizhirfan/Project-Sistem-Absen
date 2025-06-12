@extends('layout.main')
@section('content')

<div class="container mt-4">
    <form action="{{ route('laplembur.update', $laplembur->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Kolom Kiri -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" class="form-control" value="{{ $laplembur->nip }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <input type="text" class="form-control" value="{{ $laplembur->jabatan }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lembur</label>
                <input type="date" class="form-control" value="{{ $laplembur->tanggal_lembur }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Jam Mulai</label>
                <input type="time" class="form-control" value="{{ $laplembur->jam_mulai }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Durasi</label>
                <input type="text" class="form-control" value="{{ $laplembur->durasi }} Jam" readonly>
            </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" value="{{ $laplembur->nama }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Divisi</label>
                <input type="text" class="form-control" value="{{ $laplembur->divisi }}" readonly>
            </div>
            <div class="mb-3 invisible">
                <label class="form-label">&nbsp;</label>
                <input type="text" class="form-control" disabled style="opacity: 0;">
            </div>
            <div class="mb-3">
                <label class="form-label">Jam Selesai</label>
                <input type="time" class="form-control" value="{{ $laplembur->jam_selesai }}" readonly>
            </div>
        </div>
    </div>

    <!-- Keterangan -->
    <div class="mb-3">
        <label class="form-label">Keterangan</label>
        <textarea class="form-control" rows="4" readonly>{{ $laplembur->keterangan }}</textarea>
    </div>

    <!-- Tombol ACC/Tolak, hanya untuk role tertentu -->
    @if (in_array(session('role'), ['hrd', 'kepala_divisi', 'direktur']))
        <div class="mb-3 d-flex gap-2">
            <button type="submit" name="action" value="acc" class="btn btn-success px-4">
                <i class="fa-solid fa-check"></i> ACC
            </button>

            <button type="button" id="btnTolak" class="btn btn-danger px-4">
                <i class="fa-solid fa-xmark"></i> Tolak
            </button>
        </div>

        <!-- Alasan Penolakan -->
        <div id="formTolak" style="display: none;" class="mb-3">
            <label for="keterangan_penolakan" class="form-label">Alasan Penolakan</label>
            <textarea name="keterangan_penolakan" id="keterangan_penolakan" class="form-control" rows="3" required></textarea>

            <button type="submit" name="action" value="tolak" class="btn btn-danger mt-2">
                Submit Penolakan
            </button>
        </div>
    @endif
</form>

</div>

<style>
   .btn-primary {
        background-color: #0056d2; /* Warna biru sesuai Figma */
        border: none;
        color: #fff;
        border-radius: 50px; /* Bulat penuh */
        padding: 10px 24px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0041a8; /* Biru lebih gelap saat hover */
        color: #fff;
    }

    /* Form input styling */
    .form-control {
        border: 1px solid #d3dce6;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 14px;
        color: #333;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: #0056d2;
        box-shadow: 0 0 0 0.1rem rgba(0, 86, 210, 0.2);
    }

    /* Label form */
    .form-label {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 4px;
    }

    /* Headings */
    .card h4 {
        font-weight: 700;
        font-size: 20px;
    }

    .card p.fw-semibold {
        font-size: 15px;
        margin-bottom: 24px;
    }
</style>
<script>
     // Saat tombol ACC diklik, hilangkan required dari textarea
    document.querySelector('button[value="acc"]').addEventListener('click', function () {
        document.getElementById('keterangan_penolakan').removeAttribute('required');
    });

    // Saat tombol Tolak diklik, munculkan textarea & atur required
    document.getElementById('btnTolak').addEventListener('click', function () {
        document.getElementById('formTolak').style.display = 'block';
        document.getElementById('keterangan_penolakan').setAttribute('required', true);
        this.style.display = 'none';
    });

</script>



@endsection
