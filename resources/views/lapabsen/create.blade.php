<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Absen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            background-color: #dee2e6;
            padding: 15px;
            position: relative;
        }
        .header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .form-control {
        border-radius: 10px;
        border: 1px solid #d1d9e6;
        }
        .btn-primary {
        background-color: #0057d9;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        }
        .btn-lembur, .btn-cuti, .btn-izin {
        background-color: #aaa;
        color: white;
        border-radius: 20px;
        padding: 6px 20px;
        transition: background-color 0.3s, color 0.3s;
        }

        .active-btn {
        background-color: #d9530e !important;
        color: white !important;
        }

        hr {
        margin: 40px 0;
        }
        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 60px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1000;
        }

        .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            transition: background 0.2s;
        }

        .dropdown a:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

    <div class="header">
        <strong>PT XYZ</strong>
        <div class="user-menu">
            <img src="https://www.gravatar.com/avatar/?d=mp" alt="User" class="user-img" id="userIcon">

            <div class="dropdown" id="dropdownMenu">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </a>

                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>

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

            <hr>

            <p class="fw-semibold">Silahkan pilih salah satu untuk pengajuan</p>
            <div class="d-flex gap-2 pengajuan-group">
                <a href="{{ route('laplembur.create') }}" class="btn btn-lembur active-btn" id="btn-lembur">Lembur</a>
                <a href="{{ route('lapcuti.create') }}" class="btn btn-cuti" id="btn-cuti">Cuti</a>
                <a href="{{ route('lapizin.create') }}" class="btn btn-izin" id="btn-izin">Izin</a>
            </div>

        @else
            {{-- Tampilan form sebelum absen --}}
            <h3 class="fw-bold">Selamat Datang {{ session('nama') ?? 'Pengguna' }}</h3>
            <p class="fw-semibold">Silahkan isi untuk melakukan absensi</p>

            <form action="{{ route('lapabsen.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ session('nip') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" >
                    </div>
                    <div class="col-md-6">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ session('jabatan') }}" >
                    </div>
                    <div class="col-md-6">
                        <label for="divisi" class="form-label">Divisi</label>
                        <input type="text" class="form-control" id="divisi" name="divisi" value="{{ session('divisi') }}" >
                    </div>
                    <div class="col-md-6">
                        <label for="jam_absen" class="form-label">Jam Absen</label>
                        <input type="datetime-local" class="form-control" id="jam_absen" name="jam_absen" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Absen Sekarang</button>
                </div>
            </form>

            <hr>

            <p class="fw-semibold">Silahkan pilih salah satu untuk pengajuan</p>
            <div class="d-flex gap-2 pengajuan-group">
                <a href="{{ route('laplembur.create') }}" class="btn btn-lembur active-btn" id="btn-lembur">Lembur</a>
                <a href="{{ route('lapcuti.create') }}" class="btn btn-cuti" id="btn-cuti">Cuti</a>
                <a href="{{ route('lapizin.create') }}" class="btn btn-izin" id="btn-izin">Izin</a>
            </div>
        @endif
    </div>


    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('jam_absen');
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            input.value = now.toISOString().slice(0, 16); // format yyyy-MM-ddTHH:mm
        });

        const lemburBtn = document.getElementById("btn-lembur");
        const cutiBtn = document.getElementById("btn-cuti");
        const izinBtn = document.getElementById("btn-izin");

        function activateButton(btn) {
            lemburBtn.classList.remove("active-btn");
            cutiBtn.classList.remove("active-btn");
            izinBtn.classList.remove("active-btn");
            btn.classList.add("active-btn");
        }

        // Hover logic
        [cutiBtn, izinBtn].forEach((btn) => {
            btn.addEventListener("mouseenter", () => {
            lemburBtn.classList.remove("active-btn");
            btn.classList.add("active-btn");
            });
            btn.addEventListener("mouseleave", () => {
            lemburBtn.classList.add("active-btn");
            btn.classList.remove("active-btn");
            });
        });

        const userIcon = document.getElementById('userIcon');
        const dropdownMenu = document.getElementById('dropdownMenu');

        userIcon.addEventListener('click', function () {
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(e) {
            if (!userIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.display = 'none';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
