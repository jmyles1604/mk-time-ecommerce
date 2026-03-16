<?php
// dashboard.php (Account Page)

session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

require 'connect_db.php';

// Pull latest user details from DB
$user_id = (int)$_SESSION['user_id'];

$stmt = mysqli_prepare($link, "SELECT first_name, last_name, email, reg_date FROM users WHERE user_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result) ?: [
  'first_name' => $_SESSION['first_name'] ?? 'User',
  'last_name'  => $_SESSION['last_name'] ?? '',
  'email'      => '',
  'reg_date'   => null
];

mysqli_stmt_close($stmt);
mysqli_close($link);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MK Time | Account</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Alegreya SC' rel='stylesheet'>
</head>

<body>
  <?php include('nav.php'); ?>

  <div class="container py-4" style="max-width: 1000px;">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
      <div>
        <h2 class="mb-1">Welcome, <?= htmlspecialchars($user['first_name']) ?> 👋</h2>
        <p class="text-muted mb-0">This is your account area.</p>
      </div>

      <div class="d-flex gap-2">
        <a class="btn btn-outline-dark" href="products.php">Browse products</a>
        <a class="btn btn-danger" href="logout.php">Logout</a>
      </div>
    </div>

    <div class="row g-3">
      <!-- Profile card -->
      <div class="col-12 col-lg-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Your details</h5>

            <div class="mb-2">
              <div class="text-muted small">Name</div>
              <div class="fw-semibold">
                <?= htmlspecialchars(trim($user['first_name'] . ' ' . $user['last_name'])) ?>
              </div>
            </div>

            <div class="mb-2">
              <div class="text-muted small">Email</div>
              <div class="fw-semibold"><?= htmlspecialchars($user['email']) ?></div>
            </div>

            <div class="mb-0">
              <div class="text-muted small">Member since</div>
              <div class="fw-semibold">
                <?php if (!empty($user['reg_date'])): ?>
                  <?= htmlspecialchars(date('d M Y', strtotime($user['reg_date']))) ?>
                <?php else: ?>
                  -
                <?php endif; ?>
              </div>
            </div>

            <hr class="my-3">

            <div class="d-flex flex-wrap gap-2">
              <a class="btn btn-dark" href="account_settings.php">Account settings</a>
              <a class="btn btn-outline-dark" href="orders.php">Order history</a>
            </div>

            <div class="text-muted small mt-3">
              <strong>Tip:</strong> keep your account details up to date for a better shopping experience.
            </div>
          </div>
        </div>
      </div>

      <!-- Quick actions -->
      <div class="col-12 col-lg-6">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title mb-3">Quick actions</h5>

            <div class="list-group">
              <a href="forher.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                Shop For Her
                <span class="badge bg-dark rounded-pill">→</span>
              </a>
              <a href="forhim.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                Shop For Him
                <span class="badge bg-dark rounded-pill">→</span>
              </a>
              <a href="products.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                Outlet deals
                <span class="badge bg-dark rounded-pill">→</span>
              </a>
              <a href="basket.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                View basket
                <span class="badge bg-dark rounded-pill">→</span>
              </a>
            </div>

            <div class="alert alert-secondary mt-3 mb-0">
              <strong>Pro tip:</strong> add items to your basket and they will be saved here for later.
            </div>
          </div>
        </div>
      </div>

      <!-- Optional: admin hint -->
      <div class="col-12">
        <div class="card border-0 bg-light">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
              <div>
                <div class="fw-semibold">Need help?</div>
                <div class="text-muted small">Contact MK Time support or visit the FAQ.</div>
              </div>
              <div class="d-flex gap-2">
                <a class="btn btn-outline-dark" href="home.php">Back to Home</a>
                <a class="btn btn-outline-dark" href="contact.php">Contact</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include 'footer.php';
?>