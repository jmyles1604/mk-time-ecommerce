<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require('connect_db.php');
  require('login_tools.php');

  $email = $_POST['email'] ?? '';
  $pass  = $_POST['pass'] ?? '';

  list($check, $data) = validate($link, $email, $pass);

  if ($check) {
    session_start();
    $_SESSION['user_id']    = $data['user_id'];
    $_SESSION['first_name'] = $data['first_name'];
    $_SESSION['last_name']  = $data['last_name'];

    mysqli_close($link);
    header("Location: dashboard.php");
    exit();
  } else {
    $errors = $data; // array of error strings
    mysqli_close($link);
  }
}

// If not POST or failed login, show login page again with errors
include('login.php');