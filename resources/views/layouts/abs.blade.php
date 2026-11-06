<!DOCTYPE html>
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

        .navbar-custom {
            background-color: #212529;
            padding: 10px 20px;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }
        .user-icon {
            color: white;
            margin-left: 15px;
            cursor: pointer;
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
        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            background: none;
            border: none;
        }
        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background-color: #f5f5f5;
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

        .custom-button-wrapper {
            margin-top: 60px;
        }

        .custom-rounded-button {
            display: inline-block;
            background-color: #0057E7;
            color: white;
            font-weight: bold;
            padding: 12px 40px;
            border: none;
            border-radius: 999px;
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
        <a class="navbar-brand" href="#">PT XYZ</a>
        <div class="ms-auto dropdown">
            <a class="nav-link user-icon" href="#" id="userIcon">
                <i class="fas fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" id="dropdownMenu">
                <li>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    @yield('content')
    <!-- Main content -->

    <script>
        // Atur waktu sekarang ke input jam_absen
         function updateJamAbsen() {
            const input = document.getElementById('jam_absen');
            const now = new Date();

            const tgl = String(now.getDate()).padStart(2, '0');
            const bln = String(now.getMonth() + 1).padStart(2, '0');
            const thn = now.getFullYear();

            const jam = String(now.getHours()).padStart(2, '0');
            const menit = String(now.getMinutes()).padStart(2, '0');
            const detik = String(now.getSeconds()).padStart(2, '0');

            // Format: dd/mm/yyyy HH:MM:SS
            input.value = `${tgl}/${bln}/${thn} ${jam}:${menit}:${detik}`;
        }

        window.addEventListener('DOMContentLoaded', function () {
            updateJamAbsen();
            setInterval(updateJamAbsen, 1000);
        });

        // Toggle dropdown
        const userIcon = document.getElementById('userIcon');
        const dropdownMenu = document.getElementById('dropdownMenu');

        userIcon.addEventListener('click', function (e) {
            e.preventDefault();
            dropdownMenu.classList.toggle('show');
        });

        // Klik di luar dropdown akan menutup menu
        window.addEventListener('click', function (e) {
            if (!userIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
