<?php
include('nav.php');

// Display any error messages if present.
if (isset($errors) && !empty($errors)) {
  echo '<div class="container mt-3" style="max-width: 720px;">';
  echo '<div class="alert alert-danger">';
  echo '<strong>Oops!</strong> There was a problem:<br>';

  foreach ($errors as $msg) {
    echo '- ' . htmlspecialchars($msg) . '<br>';
  }

  echo '<br>Please try again or <a href="register.php">Register</a>';
  echo '</div>';
  echo '</div>';
}

// Show success message if redirected back with ?registered=1
if (isset($_GET['registered'])) {
  echo '<div class="container mt-3" style="max-width: 720px;">';
  echo '<div class="alert alert-success">';
  echo 'Account created. Please log in.';
  echo '</div>';
  echo '</div>';
}
?>



<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MK Time</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href='https://fonts.googleapis.com/css?family=Alegreya SC' rel='stylesheet'>


  <style>

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

  </style>
  
  </head>
  <body>

<div class="form-container">
  <h2>Login</h2>

  <form action="login_action.php" method="post" class="row g-3">

    <div class="col-12">
      <label for="email" class="form-label">Email</label>
      <input
        type="email"
        name="email"
        id="email"
        class="form-control"
        placeholder="Enter your email"
        required>
    </div>

    <div class="col-12">
      <label for="password" class="form-label">Password</label>
      <input
        type="password"
        name="pass"
        id="password"
        class="form-control"
        placeholder="Enter your password"
        required>
    </div>

    <div class="col-12 text-center mt-3">
      <button type="submit" class="btn btn-primary btn-lg w-50">
        Login
      </button>
    </div>

  </form>
</div>


<footer class="mt-5">
      <p class="text-center">Contact us: Edinburgh Castle, Edinburgh, EH23 666</p>
      <p class="text-center">Phone: 0131 123 4567</p>
      <p class="text-center"> MK Time 2025&trade;</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>

  </html>