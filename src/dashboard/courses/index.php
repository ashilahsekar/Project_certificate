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

$getCourses = $conn->query('SELECT * FROM courses');

while ($row = $getCourses->fetch_row()) {
    $courses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sertifikat</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="../../assets/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
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

    /* Main konten styling */
    .main-content {
        margin-left: 250px;
        /* Sesuaikan dengan lebar sidebar */
        padding: 20px;
        width: calc(100% - 250px);
        /* Mengambil sisa lebar di samping sidebar */
    }

    .search {
        width: 50%;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
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
                            <a href="../certificate/index.php" class="dropdown-item">List Sertifikat</a>
                            <a href="../certificate/create.php" class="dropdown-item">Buat Sertifikat</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="collapse" href="#pelatihanMenu" role="button" aria-expanded="false" aria-controls="pelatihanMenu">Manajemen Pelatihan</a>
                        <div class="collapse" id="pelatihanMenu">
                            <a href="index.php" class="dropdown-item">List Pelatihan</a>
                            <a href="create.php" class="dropdown-item">Tambah Pelatihan</a>
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
                            <a href="../users/" class="dropdown-item">List Pengguna</a>
                            <a href="../users/create.php" class="dropdown-item">Tambah Pengguna</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="../reports.php" class="nav-link">Laporan</a></li>
                </ul>
            </div>

            <!-- Main konten -->
            <div class="main-content">
                <h1 style="text-align: left; margin: 0;">Daftar Pelatihan</h1>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; margin-top:20px;">
                    <div class="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari Pelatihan">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">
                                    <svg class="search-icon" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1-1.415-1.414l-3.85-3.85a1 1 0 0 1 1.414-1.415l3.85 3.85a1 1 0 0 1 1.415 1.414zM6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <a href="create.php">
                        <a href="create.php" class="btn btn-primary">Tambah Pelatihan Baru</a>
                    </a>
                </div>
                <div class="table-responsive">
                    <?php if (isset($courses)) { ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pelatihan</th>
                                    <th scope="col">Tanggal Pelatihan</th>
                                    <th scope="col">Tanggal Dibuat</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $key => $course) : ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $course[1] ?></td>
                                        <td><?= $course[3] ?></td>
                                        <td><?= $course[5] ?></td>
                                        <td>
                                            <a href="edit.php?id=<?= $course[0] ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a class="btn btn-sm btn-danger" onclick="deleteCourse('<?= $course[0] ?>')" data-bs-toggle="modal" data-bs-target="#deleteCourseModal">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        NOT FOUND
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCourseModalLabel">Peringatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Setelah di hapus, data tidak dapat dikembalikan.
                </div>
                <div class="modal-footer">
                    <form action="../../service/courses.php" method="post">
                        <input type="hidden" id="deleteCourseByID" name="id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="type" value="delete" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        function deleteCourse(id) {
            document.getElementById('deleteCourseByID').value = id;
        }
    </script>
</body>

</html>