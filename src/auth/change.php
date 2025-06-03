<?php
session_start();
include '../service/utility.php';

if (isset($_SESSION['email'])) {
    return redirect("dashboard");
}

if (!isset($_GET['reset'])) {
    return redirect("auth/login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="../assets/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .login-box {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
    <!-- Tombol Kembali -->
    <div class="w-100">
        <a href="forgot.php" class="text-dark">
            <i class="bi bi-arrow-left fs-3"></i>
        </a>
    </div>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-lg-4 col-md-6 col-sm-8 col-10"> <!-- Bootstrap grid -->
            <div class="login-box shadow p-4 rounded bg-white">
                <form action="../service/auth.php" method="POST">
                    <input type="hidden" name="reset" value="<?= $_GET['reset'] ?>">
                    <div class="mb-4">
                        <h2 class="text-center">Change Password</h2>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="new_password" placeholder="Enter password" required>
                        </div>
                    </div>


                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" name="confirm_new_password" placeholder="Confirm Password" required>
                        </div>
                    </div>

                    <!-- Tombol Sign In -->
                    <div class="d-grid mb-4">
                        <button type="submit" name="type" value="edit_password" class="btn btn-primary">Change</button>
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