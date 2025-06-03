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
    case 'create':
      createUser();
      $conn->close();
      break;
    case 'delete':
      deleteUser();
      $conn->close();
      break;
    case 'edit':
      editUser();
      $conn->close();
      break;
    default:
      header('Location: ../index.php');
      break;
  }
}

function deleteUser()
{
  global $conn;

  $id = htmlspecialchars($_POST['id']);

  if (!isset($id)) {
    return redirect("dashboard/users/", "missing id", "error");
  }

  $sql = "DELETE FROM users WHERE id = $id";

  if ($conn->query($sql) == 1) {
    return redirect("dashboard/users/", "Berhasil menghapus user dengan id: $id");
  } else {
    return redirect("dashboard/users", "gagal menghapus user", "error");
  }
}

function editUser()
{
  global $conn;

  // get all user input
  $id = htmlspecialchars($_POST['id']);
  $nik = htmlspecialchars($_POST['nik']);
  $f_name = htmlspecialchars($_POST['full_name']);
  $phone_number = htmlspecialchars($_POST['phone_number']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $c_password = htmlspecialchars($_POST['c_password']);
  $role = htmlspecialchars($_POST['role']);

  if ($password !== $c_password) {
    return redirect("dashboard/users/edit.php?id=$id", "Password yang dimasukan harus sama", 'error');
  }

  // insert hash password like this
  // "salt;hash" ex: eb74a563c05dcb66b3f54e26fdfc39dd;197f1c1a6124171a77e28c7e2539c06c6c4c6852e63181030516495e2f049d99
  $salt = generateSalt();
  $hashPassword = generateHashWithSalt($password, $salt);

  $avatar = get_gravatar($email);

  $sql = "UPDATE users 
SET 
    nik = '$nik', 
    full_name = '$f_name', 
    email = '$email', 
    phone_number = '$phone_number', 
    password = '$salt;$hashPassword', 
    role = '$role'  -- Make sure to specify the column name for the role
WHERE id = $id;";
  // echo $sql; die;

  if ($conn->query($sql)) {
    return redirect("dashboard/users", "berhasil mengubah akun dengan id: $id");
  }
}

function createUser()
{
  global $conn;

  // get all user input
  $nik = htmlspecialchars($_POST['nik']);
  $f_name = htmlspecialchars($_POST['full_name']);
  $phone_number = htmlspecialchars($_POST['phone_number']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $c_password = htmlspecialchars($_POST['c_password']);
  $role = htmlspecialchars($_POST['role']);

  if ($password !== $c_password) {
    return redirect("dashboard/users/create.php", "Password yang dimasukan harus sama", 'error');
  }

  // insert hash password like this
  // "salt;hash" ex: eb74a563c05dcb66b3f54e26fdfc39dd;197f1c1a6124171a77e28c7e2539c06c6c4c6852e63181030516495e2f049d99
  $salt = generateSalt();
  $hashPassword = generateHashWithSalt($password, $salt);

  $avatar = get_gravatar($email);

  // add data to database
  $user = $conn->query("SELECT * FROM users WHERE nik = '$nik' OR email = '$email'");

  if ($user->num_rows > 0) {
    return redirect("dashboard/users/create.php", "email sudah digunakan", 'error');
  } else {
    $sql = "INSERT INTO users (nik, full_name, email, phone_number, password, role, created_at) VALUES ('$nik', '$f_name', '$email', '$phone_number', '$salt;$hashPassword', '$role', current_timestamp())";

    if ($conn->query($sql)) {
      return redirect("dashboard/users", "berhasil membuat akun baru");
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
