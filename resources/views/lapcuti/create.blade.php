<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Cuti </title>
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
        .card {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
        }
        .btn-izin {
            background-color: #6c757d;
            color: white;
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

    <div class="container mt-5">
        <h4 class="mb-1 fw-bold">Form Pengajuan Cuti</h4>
        <p class="mb-4 fw-semibold">Silahkan isi untuk pengajuan</p>

        <form action="{{ route('lapcuti.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" value="{{ session('nip') }}" >
                </div>
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ session('jabatan') }}" >
                </div>
                 <div class="mb-3">
                    <label for="tanggal_izin" class="form-label">Tanggal Cuti</label>
                    <input type="date" class="form-control" id="tanggal_izin" name="tanggal_izin" required>
                </div>
            </div>
            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ session('nama') }}" >
                </div>

                <div class="mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <input type="text" class="form-control" id="divisi" name="divisi" value="{{ session('divisi') }}">
                </div>

                <div class="mb-3">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk </label>
                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                </div>
            </div>

            <div class="col-12">
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Isi keterangan"></textarea>
            </div>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary rounded-pill px-4 me-2">Kirim Pengajuan</button>
                <button type="button" onclick="window.location='{{ route('lapabsen.create') }}'" class="btn btn-danger rounded-pill px-4">
                    Batal
                </button>

            </div>

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
