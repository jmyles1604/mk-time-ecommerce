<?php
session_start();
require('connect_db.php');

$id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;

if ($id <= 0) {
  $_SESSION['flash_message'] = 'Invalid product.';
  header("Location: member.php");
  exit();
}

$q = "SELECT product_id, name, price FROM products WHERE product_id = $id LIMIT 1";
$r = mysqli_query($link, $q);

if (!$r || mysqli_num_rows($r) !== 1) {
  $_SESSION['flash_message'] = 'Product not found.';
  header("Location: member.php");
  exit();
}

$row = mysqli_fetch_assoc($r);

// Ensure cart exists
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Add/increment
if (isset($_SESSION['cart'][$id])) {
  $_SESSION['cart'][$id]['quantity']++;
  $msg = "Another {$row['name']} has been added to your basket.";
} else {
  $_SESSION['cart'][$id] = [
    'quantity' => 1,
    'price'    => (float) $row['price']
  ];
  $msg = "{$row['name']} has been added to your basket.";
}

// Flash + redirect back
$_SESSION['flash_message'] = $msg;

mysqli_close($link);

header("Location: member.php");
exit();
?>