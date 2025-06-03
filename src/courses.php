    <?php
    session_start();

    include 'service/connection.php';
    include 'service/utility.php';

    $type = "user";

    if (isset($_SESSION['email']) && isset($_SESSION['is_auth'])) {
        $type = "user_login";
    }

    if ($type == "user") {
        $getAllCourses = $conn->query("SELECT * FROM courses");
    } else {
        $getAllCourses = $conn->query("SELECT 
            courses.id AS course_id,
            courses.event_name, 
            courses.event_description, 
            courses.event_date, 
            courses.organizer, 
            certificates.certificate_code, 
            certificates.issued_at 
        FROM 
            courses
        LEFT JOIN 
            certificates ON courses.id = certificates.event_id 
                          AND certificates.user_id = " . $_SESSION['id'] . " 
    ORDER BY 
        courses.event_date DESC");
    }

    while ($row = $getAllCourses->fetch_array(MYSQLI_ASSOC)) {
        $courses[] = $row;
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
            <h1 class="display-5 font-weight-semibold mb-3">Selamat Datang <?= $type == "user_login" ? $_SESSION['full_name'] : "" ?></h1>
            <h2 class="h5 text-dark mb-4">Lihat Pelatihan yang tersedia</h2>

            <?php if (isset($courses)) { ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card bg-light p-4 text-center shadow-sm">
                                <h3 class="card-title h5">Kategori</h3>
                                <p><?= $course['event_name'] ?></p>
                                <p><?= $course['event_date'] ?></p>
                                <div class="card-body <?= new DateTime($course['event_date']) <= new DateTime() ? "bg-danger" : (!empty($course['certificate_code']) ? "bg-success" : "bg-secondary") ?> text-light small">
                                    <?php if (!empty($course['certificate_code'])): ?>
                                        <span>Dimiliki</span>
                                    <?php else: ?>
                                        <span><?= new DateTime($course['event_date']) <= new DateTime() ? "Tidak tersedia" : "Tersedia" ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php } else { ?>
                <p>NOT AVAILABLE</p>
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