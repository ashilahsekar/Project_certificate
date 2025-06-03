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
      createCourse();
      $conn->close();
      break;
    case 'edit':
      editCourse();
      $conn->close();
      break;
    case 'delete':
      deleteCourse();
      $conn->close();
      break;
    default:
      header('Location: ../index.php');
      break;
  }
}

function deleteCourse()
{
  global $conn;

  $id = htmlspecialchars($_POST['id']);

  if (!isset($id)) {
    return redirect("dashboard/courses/", "missing id", "error");
  }

  // debug($id);

  $sql = "DELETE FROM courses WHERE id = $id";

  if ($conn->query($sql) == 1) {
    return redirect("dashboard/courses/", "Berhasil menghapus pelatihan dengan id: $id");
  } else {
    return redirect("dashboard/courses", "gagal menghapus pelatihan", "error");
  }
}

function editCourse()
{
  global $conn;

  // get all user input
  $id = htmlspecialchars($_POST['id']);
  $name = htmlspecialchars($_POST['course_name']);
  $desc = htmlspecialchars($_POST['description']);
  $course_date = htmlspecialchars($_POST['course_date']);
  $organizer = htmlspecialchars($_POST['course_organizer']);

  $sql = "UPDATE courses SET event_name = '$name', event_description = '$desc', event_date = '$course_date', organizer = '$organizer' WHERE id = $id";
  if ($conn->query($sql)) {
    return redirect("dashboard/courses", "berhasil membuat pelatihan baru");
  } else {
    return redirect("dashboard/courses", "gagal mengubah pelatihan", "error");
  }
}

function createCourse()
{
  global $conn;

  // get all user input
  $name = htmlspecialchars($_POST['course_name']);
  $desc = htmlspecialchars($_POST['description']);
  $course_date = htmlspecialchars($_POST['course_date']);
  $organizer = htmlspecialchars($_POST['course_organizer']);

  $sql = "INSERT INTO courses (event_name, event_description, event_date, organizer, created_at) VALUES ('$name', '$desc', '$course_date', '$organizer', current_timestamp())";

  if ($conn->query($sql)) {
    return redirect("dashboard/courses", "berhasil membuat pelatihan baru");
  } else {
    return redirect("dashboard/courses", "gagal mengubah pelatihan", "error");
  }
}
