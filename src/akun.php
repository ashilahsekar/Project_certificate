<?php
session_start();

include 'service/connection.php';
include 'service/utility.php';

if (!isset($_SESSION['email']) && !isset($_SESSION['is_auth'])) {
    return redirect("index.php");
}

$getAllCertificatesByIdQuery = "SELECT 
    c.id AS certificate_id,
    c.user_id,
    c.event_id,
    c.certificate_code,
    c.issued_at,
    c.certificate_template,
    cf.file_name,
    cf.field_name,
    cf.field_value,
    e.event_name,
    e.event_description,
    e.event_date,
    e.organizer,
    u.full_name,
    u.email,
    u.phone_number
FROM 
    certificates AS c
JOIN 
    certificate_fields AS cf ON c.id = cf.certificate_id
JOIN 
    courses AS e ON c.event_id = e.id
JOIN 
    users AS u ON c.user_id = u.id
WHERE 
    u.id = " . $_SESSION['id'];

$getAllCertificates = $conn->query($getAllCertificatesByIdQuery);

while ($row = $getAllCertificates->fetch_array(MYSQLI_ASSOC)) {
    $certificates[] = $row;
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Sertifikat</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="assets/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-white text-dark font-sans">

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

    <main class="container text-center my-5 p-4">
        <h1 class="display-5 font-weight-semibold mb-3">Selamat Datang <?= $_SESSION['full_name'] ?></h1>
        <h2 class="h5 text-dark mb-4">Lihat Sertifikat yang kamu punya</h2>

        <?php if (isset($certificates)) { ?>
            <div class="row">
                <?php foreach ($certificates as $certificate) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-light p-4 text-center shadow-sm">
                            <h3 class="card-title h5"><?= $certificate['event_name'] ?></h3>
                            <img src="assets/uploads/certificates/<?= $certificate['file_name'] ?>" width="300" alt="">
                            <div class="card-body bg-secondary text-light small mt-4">Dimiliki</div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php } else { ?>
            Not Found
        <?php } ?>
    </main>

    <footer class="text-center p-4 bg-dark text-white mt-5">
        <p>© 2024 Kelompok 1. Semua hak dilindungi.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

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