<?php
session_start();
require('connect_db.php');
include('nav.php');
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MK Time | Basket</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+SC" rel="stylesheet">
</head>
<body>

<?php
if (isset($_SESSION['flash_message'])) {
  $type = $_SESSION['flash_type'] ?? 'success';

  echo '
  <div class="container mt-3">
    <div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
      ' . $_SESSION['flash_message'] . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>';

  unset($_SESSION['flash_message'], $_SESSION['flash_type']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['qty'])) {
  foreach ($_POST['qty'] as $item_id => $item_qty) {
    $id = (int)$item_id;
    $qty = (int)$item_qty;

    if ($qty == 0) {
      unset($_SESSION['cart'][$id]);
    } elseif ($qty > 0) {
      $_SESSION['cart'][$id]['quantity'] = $qty;
    }
  }
}

$total = 0;

if (!empty($_SESSION['cart'])) {
  $q = "SELECT * FROM products WHERE product_id IN (";
  foreach ($_SESSION['cart'] as $id => $value) {
    $q .= $id . ',';
  }
  $q = substr($q, 0, -1) . ') ORDER BY product_id ASC';
  $r = mysqli_query($link, $q);

  echo '<form action="basket.php" method="post">';
  while ($row = mysqli_fetch_assoc($r)) {
    $subtotal = $_SESSION['cart'][$row['product_id']]['quantity'] * $_SESSION['cart'][$row['product_id']]['price'];
    $total += $subtotal;

    echo '
    <div class="container my-3">
      <div class="row align-items-center">
        <div class="col-md-2">
          <img src="' . $row['image_url'] . '" class="img-fluid rounded-3" alt="' . htmlspecialchars($row['name']) . '">
        </div>
        <div class="col-md-3">
          <h6 class="text-black mb-0">' . htmlspecialchars($row['name']) . '</h6>
        </div>
        <div class="col-md-2">
          <input type="text" class="form-control" name="qty[' . $row['product_id'] . ']" value="' . $_SESSION['cart'][$row['product_id']]['quantity'] . '">
        </div>
        <div class="col-md-2">
          £' . number_format($row['price'], 2) . '
        </div>
        <div class="col-md-3">
          <strong>£' . number_format($subtotal, 2) . '</strong>
        </div>
      </div>
    </div>';
  }

  mysqli_close($link);
  
  echo '
    <div class="container my-3">
      <div class="row align-items-center border-top pt-3">
        <div class="col-md-2"></div>
        <div class="col-md-3">
          <h5 class="mb-0">Summary</h5>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
          <strong>Total price</strong>
        </div>
        <div class="col-md-3">
          <strong>&pound ' . number_format($total, 2) . '</strong>
        </div>
      </div>
    </div>

    <div class="container my-3">
      <div class="row">
        <div class="col-md-12 d-flex flex-column align-items-end gap-2">
          <input type="submit" name="submit" class="btn btn-dark" value="Update My Cart">
          <a href="checkout.php?total=' . $total . '" class="btn btn-primary">
            Checkout: &pound ' . number_format($total, 2) . '
          </a>
        </div>
      </div>
    </div>
  </form>';
}
else 
  { echo '
  <div class="container mt-3">
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
      <p class="mb-0">Your cart is currently empty.</p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>';
}
include('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>