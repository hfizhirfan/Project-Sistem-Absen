<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Login</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tambahkan Font Awesome untuk icon mata -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="form-container bg-white p-4 rounded shadow">
            <h3 class="text-center heading-text">Selamat Datang</h3>
            <form id="loginForm" class="form-position">
                <div class="custom-margin">
                    <label for="nip" class="input-label">NIP</label>
                    <input type="text" id="nip" name="nip" class="form-control custom-input" placeholder="Masukkan NIP" required>
                </div>
                <div class="custom-margin">
                    <label for="password" class="input-label">Password</label>
                    <div class="password-input-container">
                        <input type="password" id="password" name="password" class="form-control custom-input" placeholder="Masukkan password" required>
                        <i class="fa fa-eye password-toggle" id="togglePassword"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center custom-spacing">
                    <button type="submit" id="loginBtn" class="btn btn-primary w-50 rounded-pill">Login</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script login -->
    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Form submission
        document.getElementById("loginForm").addEventListener("submit", async function (e) {
            e.preventDefault();

            const loginBtn = document.getElementById("loginBtn");
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

            try {
                const response = await fetch("{{ route('login.auth') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({
                        nip: document.getElementById("nip").value.trim(),
                        password: document.getElementById("password").value
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || "Login gagal");
                }

                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error("Login error:", error);
                alert(error.message || "Terjadi kesalahan saat login.");
            } finally {
                loginBtn.disabled = false;
                loginBtn.innerHTML = 'Login';
            }
        });
    </script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('/image/login.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            width: 606px;
            height: 630px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            margin-top: 75px;
            transform: translateX(300px);
            border-radius: 24px !important;
        }
        .form-position {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            margin-top: 50px;
        }
        .custom-input {
            width: 400px;
            height: 45px;
            padding: 10px 15px;
            font-size: 16px;
            border: 1px solid #c4c4c4;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
            color: #4a4a4a;
            background-color: #ffffff;
        }
        .custom-input::placeholder {
            color: #9a9a9a;
        }
        .custom-input:focus {
            border-color: #5a9;
            box-shadow: 0 0 5px rgba(90, 153, 90, 0.3);
        }
        .heading-text {
            margin-bottom: 40px;
            margin-top: 50px;
            font-size: 34px;
            font-weight: 600;
        }
        .custom-margin {
            margin-bottom: 24px;
        }
        .input-label {
            font-size: 16px;
            font-weight: 400;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .custom-spacing {
            margin-bottom: 120px;
        }
        .btn-primary {
            background-color: #5a9;
            border-color: #5a9;
        }
        /* Style untuk password toggle */
        .password-input-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9a9a9a;
        }
        .password-toggle:hover {
            color: #5a9;
        }
    </style>
</body>
</html>
