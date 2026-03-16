<?php
# LOGIN HELPER FUNCTIONS.
# Function to check email address and password.
function validate($link, $email = '', $pwd = '')
{
  $errors = [];

  // Basic checks
  $email = trim($email);
  $pwd   = trim($pwd);

  if ($email === '') { $errors[] = 'Enter your email address.'; }
  if ($pwd === '')   { $errors[] = 'Enter your password.'; }

  if (!empty($errors)) {
    return [false, $errors];
  }

  // Prepared statement (safer than building SQL strings)
  $q = "SELECT user_id, first_name, last_name, pass FROM users WHERE email = ? LIMIT 1";
  $stmt = mysqli_prepare($link, $q);

  if (!$stmt) {
    return [false, ['Database error.']];
  }

  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    // Verify hashed password
    if (password_verify($pwd, $row['pass'])) {

      // Optional: upgrade old hashes automatically if algorithm changes
      if (password_needs_rehash($row['pass'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($pwd, PASSWORD_DEFAULT);
        $upd = mysqli_prepare($link, "UPDATE users SET pass = ? WHERE user_id = ?");
        if ($upd) {
          mysqli_stmt_bind_param($upd, "si", $newHash, $row['user_id']);
          mysqli_stmt_execute($upd);
          mysqli_stmt_close($upd);
        }
      }

      // Return only what you need in session
      unset($row['pass']);
      mysqli_stmt_close($stmt);
      return [true, $row];
    }
  }

  mysqli_stmt_close($stmt);
  return [false, ['Email address and password not found.']];
}