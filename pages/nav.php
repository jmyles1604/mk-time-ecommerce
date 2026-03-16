<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand mk-brand" href="home.php">MK Time</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="home.php">Home</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Our Products
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="forher.php">For Her</a></li>
            <li><a class="dropdown-item" href="forhim.php">For Him</a></li>
            <li><a class="dropdown-item" href="member.php">Members Only</a></li>
            <li><a class="dropdown-item" href="products.php">Outlet</a></li>
          </ul>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
  <?php if (isset($_SESSION['user_id'])): ?>
    <li class="nav-item">
      <span class="navbar-text text-white-50">
        Hello <?= htmlspecialchars($_SESSION['first_name']) ?>
      </span>
    </li>
    <li class="nav-item"><a class="nav-link" href="dashboard.php">Account</a></li>
    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
  <?php else: ?>
    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
  <?php endif; ?>

  <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
  <li class="nav-item"><a class="nav-link" href="basket.php">Basket</a></li>
</ul>

    </div>
  </div>
</nav>