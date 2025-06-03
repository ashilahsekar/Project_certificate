<?php

// how this code work?

/**
 * See how this code work
 * 
 * 1. add this file to your form in action, don'y forget to set method to post
 * 2. set submit button with name="type" and value="purpose" ex: value="login"
 * 3. 
 */

session_start();

include 'utility.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  header('Location: ../index.php');
}

include 'connection.php';

// now you can access $conn from connection.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $type = $_POST['type'];

  switch ($type) {
    case 'login':
      login();
      $conn->close();
      break;
    case 'logout':
      logout();
      $conn->close();
      break;
    case 'register':
      register();
      $conn->close();
      break;
    case 'find_email':
      find_email();
      $conn->close();
      break;
    case 'edit_password':
      edit_password();
      $conn->close();
      break;
    default:
      header('Location: ../index.php');
      break;
  }
}

function edit_password()
{
  global $conn;

  $reset = htmlspecialchars($_POST['reset']);

  if (!isset($reset)) {
    return redirect("auth/forgot.php", "Something error, please try again from start.", "error");
  }

  $sql = "SELECT * FROM reset_password WHERE reset_token = '$reset'";

  $res = $conn->query($sql)->fetch_array();

  $email = $res['email'];

  if (!isset($res)) {
    return redirect("auth/forgot.php", "Don't do that bro!", "error");
  }

  // $oldPassword = htmlspecialchars($_POST['old_password']);
  $newPassword = htmlspecialchars($_POST['new_password']);
  $confirmNewPassword = htmlspecialchars($_POST['confirm_new_password']);

  if ($newPassword !== $confirmNewPassword) {
    return redirect('auth/forgot.php?email=' . $res['reset_token']);
  }

  //hash new password
  $salt = generateSalt();
  $hashNewPassword = generateHashWithSalt($newPassword, $salt);

  if ($conn->query("UPDATE users SET password = '$salt;$hashNewPassword' WHERE email = '$email'")) {
    $conn->query("DELETE FROM reset_password WHERE reset_token = '" . $res['reset_token'] . "'");
    return redirect("auth/login.php", "Berhasil mengubah password, silahkan login!");
  }

  return redirect("auth/forgot.php", "Failed while reset your password.", "error");
}

function find_email()
{
  global $conn;
  $email = htmlspecialchars($_POST['email']);

  $sql = "SELECT * FROM users WHERE email = '$email'";

  $res = $conn->query($sql);

  if ($res->num_rows > 0) {
    // add record reset_password

    $reset = bin2hex(random_bytes(40));
    $email = $res->fetch_array()['email']; // get the email
    $sql = "INSERT INTO reset_password (`reset_token`, `email`) VALUES('$reset', '$email')";

    $conn->query($sql);

    return redirect('auth/change.php?reset=' . $reset);
  } else {
    return redirect("auth/forgot.php", "Username atau password tidak di temukan.", "error");
  }
}

function login()
{
  global $conn;
  // get email and password
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);

  $sql = "SELECT * FROM users WHERE email = '$email'";

  $res = $conn->query($sql)->fetch_array();

  // get salt
  $salt = explode(";", $res['password'])[0];
  $hashPassword = explode(";", $res['password'])[1];

  $currentHashPassword = generateHashWithSalt($password, $salt);

  if ($currentHashPassword !== $hashPassword) {
    return redirect("auth/login.php", "email atau password tidak di temukan.", "error");
  }

  if ($res != null) {
    // set 1st user to admin
    if ($res['id'] == 1 && $res['role'] != 'admin') {
      $conn->query("UPDATE users SET role = 'admin' WHERE email = '$email'");
    }

    $_SESSION['email'] = $res['email'];
    $_SESSION['full_name'] = $res['full_name'];
    $_SESSION['role'] = $res['role'];
    $_SESSION['avatar'] = $res['avatar'];
    $_SESSION['is_auth'] = true;
    $_SESSION['id'] = $res['id'];

    // $_SESSION['success'] = "Berhasil Login";
    // header('Location: ../dashboard.php');
    // exit();
    if ($_SESSION['role'] == 'admin') {
      return redirect("dashboard", "Berhasil Login");
    }

    return redirect("akun.php", "Berhasil Login");
  } else {
    return redirect("auth/login.php", "email atau password tidak di temukan.", "error");
  }
}

function logout()
{
  session_start();
  session_destroy();
  session_start();

  return redirect("index.php", "Berhasil logout", "success");
}

function register()
{
  global $conn;

  // get all user input
  $nik = htmlspecialchars($_POST['nik']);
  $f_name = htmlspecialchars($_POST['f_name']);
  $phone_number = htmlspecialchars($_POST['phone_number']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $c_password = htmlspecialchars($_POST['c_password']);

  if ($password !== $c_password) {
    return redirect("auth/register.php", "Password yang dimasukan harus sama", 'error');
  }

  // insert hash password like this
  // "salt;hash" ex: eb74a563c05dcb66b3f54e26fdfc39dd;197f1c1a6124171a77e28c7e2539c06c6c4c6852e63181030516495e2f049d99
  $salt = generateSalt();
  $hashPassword = generateHashWithSalt($password, $salt);

  $avatar = get_gravatar($email);

  // add data to database
  $user = $conn->query("SELECT * FROM users WHERE nik = '$nik' OR email = '$email'");

  if ($user->num_rows > 0) {
    return redirect("auth/register.php", "email sudah digunakan", 'error');
  } else {
    $sql = "INSERT INTO users (nik, full_name, email, phone_number, password, role, created_at) VALUES ('$nik', '$f_name', '$email', '$phone_number', '$salt;$hashPassword', 'participant', current_timestamp())";

    if ($conn->query($sql)) {
      return redirect("auth/login.php", "berhasil membuat akun baru");
    }
  }
}

function generateSalt($length = 16)
{
  // Menghasilkan salt acak dengan panjang tertentu
  return bin2hex(random_bytes($length));
}

function generateHashWithSalt($password, $salt)
{
  // Menggabungkan password dengan salt dan menghasilkan hash SHA-256
  return hash('sha256', $salt . $password);
}
