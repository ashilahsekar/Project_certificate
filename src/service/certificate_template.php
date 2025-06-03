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
      createTemplate();
      $conn->close();
      break;
    case 'edit':
      editTemplate();
      $conn->close();
      break;
    case 'delete':
      deleteTemplate();
      $conn->close();
      break;
    default:
      header('Location: ../index.php');
      break;
  }
}

function createTemplate()
{
  global $conn;

  $name = htmlspecialchars($_POST['template_name']);
  $desc = htmlspecialchars($_POST['description']);

  $slug_id = slugify($name);

  // add data to database
  $user = $conn->query("SELECT * FROM certificate_templates WHERE id = '$slug_id'");

  if ($user->num_rows > 0) {
    return redirect("dashboard/certificate-template/create.php", "nama file sudah digunakan", 'error');
  } else {

    $file = $_FILES['template_file'];
    $template = upload($file, $slug_id);

    if (is_null($template[0])) {
      return redirect("dashboard/certificate-template", $template[1], "error");
    }

    $sql = "INSERT INTO certificate_templates (id, file_name, template_name, template_desc, uploader_id, created_at) VALUES ('$slug_id', '" . $template[0] . "', '$name', '$desc', '" . $_SESSION['id'] . "', current_timestamp())";

    if ($conn->query($sql)) {
      return redirect("dashboard/certificate-template", "berhasil membuat template baru");
    }
  }
}

function editTemplate()
{
  global $conn;

  $id = htmlspecialchars($_POST['id']);
  $name = htmlspecialchars($_POST['template_name']);
  $desc = htmlspecialchars($_POST['description']);

  $slug_id = slugify($name);

  // add data to database
  $templateData = $conn->query("SELECT * FROM certificate_templates WHERE id = '$slug_id'");

  if ($templateData->num_rows > 0) {
    return redirect("dashboard/certificate-template/edit.php?id=$id", "nama file sudah digunakan", 'error');
  } else {

    $file = $_FILES['template_file'];

    // hapus gambar sebelumnya
    $filePath = "../assets/uploads/templates/" . $templateData->fetch_array()['file_name'];

    if (file_exists($filePath)) {
      if (!unlink($filePath)) {
        return redirect("dashboard/certificate-template", "Error saat menghapus gambar, silahkan ulang lagi nanti", 'error');
      }
    }

    $template = upload($file, $slug_id);

    if (is_null($template[0])) {
      return redirect("dashboard/certificate-template", $template[1], "error");
    }

    $sql = "UPDATE certificate_templates SET id = '$slug_id, file_name = '" . $template[0] . "', template_name = '$name', template_desc = '$desc', uploader_id = '" . $_SESSION['id'] . "' WHERE id = '$id'";

    if ($conn->query($sql)) {
      return redirect("dashboard/certificate-template", "berhasil membuat template baru");
    }
  }
}

function deleteTemplate()
{
  global $conn;

  $id = htmlspecialchars($_POST['id']);

  if (!isset($id)) {
    return redirect("dashboard/certificate-template/", "Sertifikat tidak ditemukan", "error");
  }

  // hapus gambar sebelumnya
  $templateData = $conn->query("SELECT * FROM certificate_templates WHERE id = '$id'");
  $filePath = "../assets/uploads/templates/" . $templateData->fetch_array()['file_name'];

  if (file_exists($filePath)) {
    if (!unlink($filePath)) {
      return redirect("dashboard/certificate-template", "Error saat menghapus gambar, silahkan ulang lagi nanti", 'error');
    }
  }

  $sql = "DELETE FROM certificate_templates WHERE id = '$id'";

  if ($conn->query($sql) == 1) {
    return redirect("dashboard/certificate-template/", "Berhasil menghapus pelatihan dengan id: $id");
  } else {
    return redirect("dashboard/certificate-template", "gagal menghapus pelatihan", "error");
  }
}

function upload(array $file, $fileNameSlug)
{

  $fileName = $file['name'];
  $fileSize = $file['size'];
  $fileErr = $file['error'];
  $fileTmp = $file['tmp_name'];

  if ($fileErr === 4) {
    return [null, "Gambar tidak ditemukan, upload gambar terlebih dahulu"];
  }

  $validExstension = ['png'];
  $fileExstension = explode('.', $fileName);
  $fileExstension = end($fileExstension);
  $fileExstension = strtolower($fileExstension);

  if (!in_array($fileExstension, $validExstension)) {
    return [null, "Tipe upload file harus berupa .png"];
  }

  if (!is_dir("../assets/uploads/templates")) {
    mkdir("../assets/uploads/templates", 0777);
  }

  // upload gambar
  move_uploaded_file($fileTmp, "../assets/uploads/templates/" . $fileNameSlug . ".png");
  chgrp("../assets/uploads/templates/" . $fileNameSlug . ".png", 'www-data');
  chown("../assets/uploads/templates/" . $fileNameSlug . ".png", "www-data");

  return [$fileNameSlug . ".png", null];
}
