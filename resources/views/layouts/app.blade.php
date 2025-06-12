<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Halaman')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .navbar-custom {
            background-color: #212529;
            padding: 10px 20px;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .form-control {
            color: white;
        }
        .user-icon {
            color: white;
            margin-left: 15px;
            cursor: pointer;
        }
        .dropdown {
            position: relative;
        }
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 40px;
            display: none;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 1000;
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-menu a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
        }
        .dropdown-menu a:hover {
            background-color: #f5f5f5;
        }

        .custom-button-wrapper {
            margin-top: 60px; /* Jarak antar elemen */
        }

        .custom-rounded-button {
            display: inline-block;
            background-color: #0057E7; /* Warna biru terang */
            color: white;
            font-weight: bold;
            padding: 12px 40px;
            border: none;
            border-radius: 999px; /* Biar super bulat */
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .custom-rounded-button:hover {
            background-color: #fefefe;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <a class="navbar-brand">PT XYZ</a>
        <div class="ms-auto dropdown">
            <a class="nav-link user-icon" href="#" id="userIcon">
                <i class="fas fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" id="dropdownMenu">
                <li>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    @if (isset($izinStatus) && $izinStatus == 'disetujui')
        <div class="alert alert-success">
            Pengajuan izin Anda telah <strong>disetujui</strong> oleh semua pihak.
            @if ($pdfAvailable)
                <br>
                <a href="{{ route('izin.download.pdf', $izin->id) }}" class="btn btn-outline-primary mt-2">
                    <i class="fas fa-file-download"></i> Download PDF Izin
                </a>
            @endif
        </div>
    @elseif (isset($izinStatus) && $izinStatus == 'ditolak')
        <div class="alert alert-danger">
            Pengajuan izin Anda telah <strong>ditolak</strong>. Alasan:
            <br>
            <em>{{ $izin->keterangan_penolakan ?? 'Tidak ada keterangan' }}</em>
        </div>
    @endif

    @yield('content')
    <!-- Main content -->

    <!-- JS -->
    <script>
        // Set nilai jam absen ke waktu sekarang saat halaman dimuat
        window.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('jam_absen');
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            input.value = now.toISOString().slice(0, 16);
        });

        // Highlight tombol pengajuan saat hover
        const lemburBtn = document.getElementById("btn-lembur");
        const cutiBtn = document.getElementById("btn-cuti");
        const izinBtn = document.getElementById("btn-izin");

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

        // Dropdown toggle
        const userIcon = document.getElementById('userIcon');
        const dropdownMenu = document.getElementById('dropdownMenu');

        userIcon.addEventListener('click', function (e) {
            e.preventDefault();
            dropdownMenu.classList.toggle('show');
        });

        window.addEventListener('click', function (e) {
            if (!userIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
