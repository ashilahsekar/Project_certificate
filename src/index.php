<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Sertifikat SMKN 71</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="assets/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header style="background-color: white; border-bottom: 1px solid #ddd; padding: 1rem;">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <div class="logo" style="display: flex; align-items: center;">
                <img src="assets/logo.png" alt="Logo" style="width: 60px; height: 60px;">
                <h1 style="font-size: 24px; font-weight: bold; margin-left: 10px;">E-Sertifikat</h1>
            </div>
            <nav style="    display: flex; align-items: center;">
                <a href="index.php" style="margin: 0 15px; text-decoration: none; color: black; font-weight: 500;">Home</a>
                <a href="#" style="margin: 0 15px; text-decoration: none; color: black; font-weight: 500;">Tentang Kami</a>
                <a href="cek-sertifikat.php" style="margin: 0 15px; text-decoration: none; color: black; font-weight: 500;">Cek Sertifikat</a>
                <a href="courses.php" style="margin: 0 15px; text-decoration: none; color: black; font-weight: 500;">Pelatihan</a>
                <?php if (isset($_SESSION['role'])) { ?>
                    <?php if ($_SESSION['role'] != "admin") { ?>
                        <a href="akun.php" style="margin: 0 15px; text-decoration: none; color: black; font-weight: 500;">Akun</a>
                    <?php } else { ?>
                        <a href="dashboard/" style="margin: 0 15px; text-decoration: none; color: black; font-weight: 500;">Dashboard</a>
                    <?php } ?>
                <?php } ?>

                <?php if (isset($_SESSION['email'])) { ?>
                    <form style="margin-left: 1em!important;" action="service/auth.php" method="post">
                        <button type="submit" name="type" value="logout" class="btn btn-outline-primary">Logout</button>
                    </form>
                <?php } else { ?>
                    <a href="auth/login.php" class="btn btn-outline-primary">Login</a>
                <?php } ?>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero-section">
            <div class="container text-center">
                <h1>SELAMAT DATANG DI <br> E-SERTIFIKAT SMKN 71</h1>
                <hr>
            </div>
        </section>

        <section class="about-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Apa Itu E-Sertifikat</h3>
                        <p>E-sertifikat adalah sertifikat yang dikeluarkan dalam bentuk digital dan disimpan dalam format elektronik. Berbeda dengan sertifikat tradisional yang berbentuk fisik, e-sertifikat dapat diakses melalui perangkat elektronik seperti komputer, tablet, atau smartphone.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="tujuan-section py-5 bg-light">
            <div class="container">
                <div class="row" style="justify-content: flex-end;">
                    <div class="col-lg-6">
                        <h3>Tujuan</h3>
                        <p>Maksud pemerintah kabupaten dalam Corporate Social Responsibility (CSR) adalah untuk menciptakan sinergi yang kuat antara pemerintah, perusahaan, dan masyarakat...</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer style="background-color: #1d3c6e; color: white; text-align: center; padding: 1rem;">
        <p>© 2024 Kelompok 1. Semua hak dilindungi.</p>
    </footer>

    <script src="assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <?php
    if (isset($_SESSION['success'])) {
        if (strlen($_SESSION['success']) > 3) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '" . $_SESSION['success'] . "',
                showConfirmButton: true
            });
        </script>";
        }
        unset($_SESSION['success']); // Clear the session variable
    }

    if (isset($_SESSION['error'])) {
        if (strlen($_SESSION['error']) > 3) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '" . $_SESSION['error'] . "',
                showConfirmButton: true
            });
        </script>";
        }
        unset($_SESSION['error']); // Clear the session variable
    }
    ?>
</body>

</html>