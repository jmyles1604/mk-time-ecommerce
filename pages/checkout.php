<?php
session_start();

include('nav.php');

$cart = $_SESSION['cart'] ?? [];

if (empty($_SESSION['user_id'])) {
  $_SESSION['flash_message'] = "You must be logged in to checkout.";
  $_SESSION['flash_type'] = "danger";
  header("Location: basket.php");
  exit();
}

if (empty($cart)) {
  $_SESSION['flash_message'] = "There are no items in your basket.";
  $_SESSION['flash_type'] = "warning";
  header("Location: basket.php");
  exit();
}

require('connect_db.php');

// Build safe id list
$ids = array_map('intval', array_keys($cart));
$idList = implode(',', $ids);

// Pull real prices (use product_id)
$q = "SELECT product_id, name, price FROM products WHERE product_id IN ($idList)";
$r = mysqli_query($link, $q);

if (!$r) {
  $_SESSION['flash_message'] = "Checkout failed (could not read products): " . mysqli_error($link);
  $_SESSION['flash_type'] = "danger";
  header("Location: basket.php");
  exit();
}

$products = [];
while ($row = mysqli_fetch_assoc($r)) {
  $products[(int)$row['product_id']] = $row;
}

// Calculate total from DB prices
$total = 0.0;
foreach ($cart as $pid => $data) {
  $pid = (int)$pid;
  $qty = (int)($data['quantity'] ?? 0);

  if ($qty <= 0 || !isset($products[$pid])) continue;

  $total += (float)$products[$pid]['price'] * $qty;
}

if ($total <= 0) {
  $_SESSION['flash_message'] = "Checkout failed (basket invalid).";
  $_SESSION['flash_type'] = "danger";
  header("Location: basket.php");
  exit();
}

mysqli_begin_transaction($link);

try {
  $user_id = (int)$_SESSION['user_id'];
  $total_sql = (float)$total;

  // Create order
  $q = "INSERT INTO orders (user_id, total, order_date) VALUES ($user_id, $total_sql, NOW())";
  if (!mysqli_query($link, $q)) {
    throw new Exception("Failed to create order: " . mysqli_error($link));
  }

  $order_id = mysqli_insert_id($link);

  // Add items
  foreach ($cart as $pid => $data) {
    $pid = (int)$pid;
    $qty = (int)($data['quantity'] ?? 0);

    if ($qty <= 0 || !isset($products[$pid])) continue;

    $price = (float)$products[$pid]['price'];

    // order_contents uses order_id + product_id
    $q = "INSERT INTO order_contents (order_id, product_id, quantity, price)
          VALUES ($order_id, $pid, $qty, $price)";

    if (!mysqli_query($link, $q)) {
      throw new Exception("Failed to add order item: " . mysqli_error($link));
    }
  }

  mysqli_commit($link);

  // Clear cart + flash success
  unset($_SESSION['cart']);
  $_SESSION['flash_message'] = "Order placed successfully. Your order number is #$order_id.";
  $_SESSION['flash_type'] = "success";

  mysqli_close($link);

  header("Location: basket.php");
  exit();

} catch (Exception $e) {
  mysqli_rollback($link);

  $_SESSION['flash_message'] = "Checkout failed: " . $e->getMessage();
  $_SESSION['flash_type'] = "danger";

  mysqli_close($link);

  header("Location: basket.php");
  exit();
}

include('footer.php'); ?>