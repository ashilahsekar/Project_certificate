<?php
session_start();
include '../service/utility.php';

if (isset($_SESSION['email'])) {
    return redirect("dashboard");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="../assets/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .register-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-top: 80px;
            margin-bottom: 200px;
        }

        body {
            background-color: #f5f5f5;
        }

        footer {
            background-color: #1d3c6e;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container d-flex flex-column min-vh-100 justify-content-center align-items-center">

        <!-- Tombol Kembali -->
        <div class="w-100">
            <a href="login.php" class="text-dark">
                <i class="bi bi-arrow-left fs-3"></i>
            </a>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-8 col-10"> <!-- Bootstrap grid -->
            <!-- Form Registrasi -->
            <div class="register-box">
                <h3 class="text-center mb-4">Register</h3>
                <form action="../service/auth.php" method="POST">
                    <!-- Nama Lengkap -->
                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="f_name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <!-- NIK -->
                    <div class="form-group mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK" required>
                    </div>
                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                    </div>
                    <!-- Phone Number -->
                    <div class="form-group mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan nomor handphone" required>
                    </div>
                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <!-- Konfirmasi Password -->
                    <div class="form-group mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="c_password" placeholder="Konfirmasi password" required>
                    </div>
                    <br>
                    <!-- Tombol Sign Up -->
                    <div class="d-grid mb-3">
                        <button type="submit" name="type" value="register" class="btn btn-primary">Sign up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-100 text-center py-3 mt-auto">
        <p>© 2024 Kelompok 1. Semua hak dilindungi.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>