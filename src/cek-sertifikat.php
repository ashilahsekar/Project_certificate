<?php
session_start();

include 'service/connection.php';
include 'service/utility.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cari'])) {
        $id = htmlspecialchars($_POST['id']);

        $getCert = $conn->query("SELECT c.*, cf.field_name, cf.field_value, u.*, e.*
            FROM certificates c
            JOIN certificate_fields cf ON c.id = cf.certificate_id 
            JOIN users u ON c.user_id = u.id 
            JOIN courses e ON c.event_id = e.id 
            WHERE c.certificate_code = '$id'");

        if ($getCert->num_rows < 1) {
            return redirect("src/cek-sertifikat.php", "Sertifikat tidak tersedia", "error");
        }

        $ceertificationDetails = $getCert->fetch_array();

        print_r($ceertificationDetails);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek E-Sertifikat Kelulusan</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css"> -->
    <link href="assets/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f8f9fa;">

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

    <!-- Main Content -->
    <main style="max-width: 1200px; margin: 50px auto; display: flex; justify-content: space-between;">
        <!-- Cek Sertifikat Section -->
        <div style="flex-basis: 60%; padding-right: 20px;">
            <h2 style="font-weight: bold;">Cek E-Sertifikat Pelatihan</h2>
            <p>Silahkan cek e-sertifikat (hanya berlaku untuk e-sertifikat yang terbit mulai tahun 2024)</p>
            <!-- Form -->
            <form action="certificate-details.php" method="post">
                <div class="input-group mb-3" style="width: 100%;">
                    <input type="text" class="form-control" placeholder="masukan id atau nik" aria-label="masukan id atau nik" name="id" style="border-radius: 5px; border: 2px solid #007bff; padding: 10px;">
                    <button class="btn btn-primary" type="submit" name="cari" value="cari" style="border-radius: 5px; margin-left: 10px; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16" style="margin-right: 5px;">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.442 0a5.5 5.5 0 1 1 7.78 0 5.5 5.5 0 0 1-7.78 0z" />
                        </svg>
                        Cek
                    </button>
                </div>
            </form>
        </div>

        <!-- Panduan Section -->
        <div style="flex-basis: 35%; background-color: #f1f3f5; padding: 20px; border-radius: 8px;">
            <h3 style="font-weight: bold;">Panduan</h3>
            <p>Cari sertifikat dengan menggunakan nomor registrasi pelatihan yang tertera di sertifikat atau dengan kode QR. Nomor registrasi dan kode QR dapat dilihat pada bagian yang ditandai merah.</p>
            <img src="assets/sertif.jpeg" alt="Panduan Sertifikat" style="width: 100%; height: auto; border-radius: 8px;">
        </div>
    </main>

    <!-- Footer -->
    <footer style="background-color: #1d3c6e; color: white; text-align: center; padding: 1rem;">
        <p>© 2024 Kelompok 1. Semua hak dilindungi.</p>
    </footer>

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