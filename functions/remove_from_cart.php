<?php
session_start();

$id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

if ($id > 0 && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
    $_SESSION['flash_message'] = "Item removed from cart.";
}

$_SESSION['flash_message'] = "Item removed from cart.";
header("Location: basket.php");
exit();

exit();
?>