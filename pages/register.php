<?php
include('nav.php');

$errors = [];
$fn = $ln = $e = '';

// Only process when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  require 'connect_db.php';

  // First name
  $fn = trim($_POST['first_name'] ?? '');
  if ($fn === '') {
    $errors[] = 'Enter your first name.';
  } else {
    $fn = mysqli_real_escape_string($link, $fn);
  }

  // Last name
  $ln = trim($_POST['last_name'] ?? '');
  if ($ln === '') {
    $errors[] = 'Enter your last name.';
  } else {
    $ln = mysqli_real_escape_string($link, $ln);
  }

  // Email
  $e = trim($_POST['email'] ?? '');
  if ($e === '') {
    $errors[] = 'Enter your email address.';
  } elseif (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Enter a valid email address.';
  } else {
    $e = mysqli_real_escape_string($link, $e);
  }

  // Passwords
  $pass1 = $_POST['pass1'] ?? '';
  $pass2 = $_POST['pass2'] ?? '';

  if ($pass1 === '' || $pass2 === '') {
    $errors[] = 'Enter your password.';
  } elseif ($pass1 !== $pass2) {
    $errors[] = 'Passwords do not match.';
  }

  // If no errors, check if email exists + insert
  if (empty($errors)) {

    $q = "SELECT user_id FROM users WHERE email='$e' LIMIT 1";
    $r = mysqli_query($link, $q);

    if ($r && mysqli_num_rows($r) > 0) {
      $errors[] = 'Email address already registered. <a class="alert-link" href="login.php">Sign In Now</a>';
    } else {

      // ✅ HASH PASSWORD (do not store plain text)
      $hashed = password_hash($pass1, PASSWORD_DEFAULT);
      $hashed = mysqli_real_escape_string($link, $hashed);

      $q = "INSERT INTO users (first_name, last_name, email, pass, reg_date)
            VALUES ('$fn', '$ln', '$e', '$hashed', NOW())";

      $r = mysqli_query($link, $q);

      if ($r) {
        mysqli_close($link);
        header("Location: login.php?registered=1");
        exit();
      } else {
        $errors[] = "Database insert failed.";
      }
    }
  }

  mysqli_close($link);
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MK Time</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css?family=Alegreya+SC" rel="stylesheet">

  <style>
    .form-container {
      max-width: 900px;
      margin: 20px auto;
      padding: 90px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
    }
    .form-container input {
      width: 100%;
      padding: 16px;
      margin: 12px 0;
      font-size: 18px;
      border-radius: 8px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    button {
      display: block;
      margin: 20px auto 0;
      background-color: rgb(1, 54, 1);
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
    }
  </style>
</head>

<body>

<div class="container mt-3" style="max-width: 900px;">
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <h4 class="alert-heading mb-2">The following error(s) occurred:</h4>
      <ul class="mb-0">
        <?php foreach ($errors as $msg): ?>
          <li><?= $msg ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>

<div class="form-container">
  <h2>Register With Us</h2>
  <p><em>for 10% off your first order</em></p>

  <form method="POST" action="register.php">
    <input name="first_name" placeholder="First Name" required value="<?= htmlspecialchars($fn) ?>">
    <input name="last_name" placeholder="Last Name" required value="<?= htmlspecialchars($ln) ?>">
    <input name="email" type="email" placeholder="Email" required value="<?= htmlspecialchars($e) ?>">
    <input name="pass1" type="password" placeholder="Password" required>
    <input name="pass2" type="password" placeholder="Confirm Password" required>
    <button type="submit"><strong>Create account</strong></button>
  </form>
</div>

<footer class="mt-5">
  <p class="text-center">Contact us: Edinburgh Castle, Edinburgh, EH23 666</p>
  <p class="text-center">Phone: 0131 123 4567</p>
  <p class="text-center">MK Time 2025&trade;</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>