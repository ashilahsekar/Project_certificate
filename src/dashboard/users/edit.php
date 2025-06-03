<?php
session_start();

include '../../service/utility.php';
include '../../service/connection.php';

if (!isset($_SESSION['email']) && !isset($_SESSION['is_auth'])) {
    return redirect("index.php");
}

if($_SESSION['role'] != "admin") {
    return redirect("index.php");
}

if (!isset($_GET['id'])) {
    return redirect("/users");
}

$getUser = $conn->query("SELECT * FROM users WHERE id =" . $_GET['id'])->fetch_array();
// print_r($getUser);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sertifikat</title>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="../../assets/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Sidebar styling */
        .sidebar {
            background-color: #1d3c6e;
            color: white;
            height: 100vh;
            width: 250px;
            position: fixed;
        }

        .sidebar h4 {
            margin-top: 20px;
            font-size: 18px;
        }

        .nav-link {
            color: white;
            padding-left: 20px;
        }

        .nav-link:hover,
        .dropdown-item:hover {
            background-color: #2a4b8e;
            color: #ffffff !important;
        }

        .dropdown-item {
            padding-left: 30px;
        }

        /* Main content styling */
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f1f1f1;
            min-height: 100vh;
        }

        .stat-box {
            background-color: #1d3c6e;
            color: white;
            border-radius: 8px;
        }

        .cert-box {
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .btn-dark {
            background-color: #4c4c4c;
            color: white;
            border: none;
        }

        .btn-dark:hover {
            background-color: #333333;
        }

        .container {
            width: 1201px;
            height: 200px;
            background-color: gray;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-box {
            width: 300px;
            height: 150px;
            background-color: #0A3067;
            /* Navy blue color */
            color: white;
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            margin: 0 10px;
            border-radius: 10px;
            font-size: 1.2em;
        }

        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #003366;
            color: white;
            height: 100vh;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .content {
            padding: 20px;
        }

        .form-container {
            background-color: #003366;
            padding: 20px;
            border-radius: 10px;
            color: white;
        }

        .form-container input,
        select,
        .form-container textarea {
            background-color: #e9ecef;
            border: none;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
        }

        .form-container input[type="file"] {
            padding: 3px;
        }

        .form-container label {
            margin-bottom: 5px;
        }

        .form-container .btn {
            width: 100px;
            margin: 5px;
        }

        .footer {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .header {
            background-color: #e9ecef;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="text-center my-3">
            <img src="../../assets/logo.png" alt="Logo" style="max-width: 80px;">
            <h4>Dashboard Sertifikat</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="../index.php" class="nav-link">Beranda</a></li>
            <!-- Manajemen Sertifikat Dropdown -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#sertifikatMenu" role="button" aria-expanded="false" aria-controls="sertifikatMenu">Manajemen Sertifikat</a>
                <div class="collapse" id="sertifikatMenu">
                    <a href="../certificate" class="dropdown-item">List Sertifikat</a>
                    <a href="../certificate/create.php" class="dropdown-item">Buat Sertifikat</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#pelatihanMenu" role="button" aria-expanded="false" aria-controls="pelatihanMenu">Manajemen Pelatihan</a>
                <div class="collapse" id="pelatihanMenu">
                    <a href="../courses" class="dropdown-item">List Pelatihan</a>
                    <a href="../courses/create.php" class="dropdown-item">Tambah Pelatihan</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#templateSertifikat" role="button" aria-expanded="false" aria-controls="templateSertifikat">Manajemen Template Sertifikat</a>
                <div class="collapse" id="templateSertifikat">
                    <a href="../certificate-template/" class="dropdown-item">List Template</a>
                    <a href="../certificate-template/create.php" class="dropdown-item">Tambah Template</a>
                </div>
            </li>
            <!-- Manajemen Pengguna Dropdown -->
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#penggunaMenu" role="button" aria-expanded="false" aria-controls="penggunaMenu">Manajemen Pengguna</a>
                <div class="collapse" id="penggunaMenu">
                    <a href="index.php" class="dropdown-item">List Pengguna</a>
                    <a href="create.php" class="dropdown-item">Tambah Pengguna</a>
                </div>
            </li>
            <li class="nav-item"><a href="../reports.php" class="nav-link">Laporan</a></li>
        </ul>
    </div>

    </div>
    <div class="content flex-grow-1">
        <div class="header">
            <h1>
                Tambah Pengguna
            </h1>
            <div class="user-info">
                <span>
                    <?= $_SESSION['full_name'] ?>
                </span>
                <i class="fas fa-user-circle">
                </i>
                <i class="fas fa-sign-out-alt">
                </i>
            </div>
        </div>
        <div class="mt-4">
            <h2>
                Formulir Tambah Pengguna
            </h2>
            <div class="form-container">
                <form method="POST" action="../../service/users.php">
                    <input type="hidden" name="id" value="<?= $getUser['id'] ?>">
                    <label for="nik">
                        NIK
                    </label>
                    <input id="nik" name="nik" placeholder="Ketik nik di sini" type="number" value="<?= $getUser['nik'] ?>" required />

                    <label for="username">
                        Nama Pengguna
                    </label>
                    <input id="username" name="full_name" placeholder="Ketik nama di sini" type="text" value="<?= $getUser['full_name'] ?>" required />

                    <label for="phone_number">
                        Nomor Telepon Pengguna
                    </label>
                    <input id="phone_number" name="phone_number" placeholder="Ketik nomor telepon di sini" type="number" value="<?= $getUser['phone_number'] ?>" required />

                    <label for="email">
                        Email Pengguna
                    </label>
                    <input id="email" name="email" placeholder="Ketik email di sini" type="email" value="<?= $getUser['email'] ?>" required />

                    <label for="password">
                        Kata Sandi
                    </label>
                    <input id="password" name="password" placeholder="Ketik kata sandi di sini" type="password" required />

                    <label for="confirm-password">
                        Konfirmasi Kata Sandi
                    </label>
                    <input id="confirm-password" name="c_password" placeholder="Ketik ulang kata sandi di sini" type="password" required />

                    <label for="category">
                        Kategori Pengguna
                    </label>
                    <select id="category" name="role" required>
                        <option value="<?= $getUser["role"] ?>" selected>default: <?= $getUser["role"] ?></option>
                        <option value="participant">participant</option>
                        <option value="admin">admin</option>
                    </select>

                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-cancel me-2" type="button">
                            Batal
                        </button>
                        <button class="btn btn-save" type="submit" name="type" value="edit">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
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