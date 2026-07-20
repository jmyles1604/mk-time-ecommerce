<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MK Time</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link href="style.css" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Alegreya SC' rel='stylesheet'>

</head>

<?php
include 'nav.php';
require 'connect_db.php';
?>

<body>

<div id="container" class="container mt-4">

    <header>
        <h1 class="main-header text-center">For Him</h1>

        <form method="GET" class="row justify-content-center mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        placeholder="Search for a watch..."
                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-dark" type="submit">
                        Search
                    </button>
                </div>
            </div>
        </form>

    </header>

<?php

echo '<div class="container">
        <div class="row">';

$search = '';

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($link, $_GET['search']);
}

if ($search != '') {

    $q = "SELECT * FROM products
          WHERE product_id IN (5,6,7,8)
          AND name LIKE '%$search%'";

} else {

    $q = "SELECT * FROM products
          WHERE product_id IN (5,6,7,8)";
}

$r = mysqli_query($link, $q);

if (mysqli_num_rows($r) > 0)
{
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
    {
        echo '
        <div class="col-md-3 d-flex justify-content-center">
            <div class="card" style="width: 18rem;">
                <img src="'.$row['image_url'].'" class="card-img-top" alt="'.$row['name'].'">
                <div class="card-body text-center">
                    <h5 class="card-title">'.$row['name'].'</h5>
                    <p class="card-text">'.$row['description'].'</p>
                </div>

                <div class="card-footer bg-transparent border-dark text-center">
                    <p class="card-text"><strong>&pound;'.$row['price'].'</strong></p>
                </div>

                <div class="card-footer text-muted">
                    <a href="add_to_cart.php?product_id='.$row['product_id'].'" class="btn btn-primary btn-block">
                        Add to Basket
                    </a>
                </div>
            </div>
        </div>';
    }

    mysqli_close($link);
}
else
{
    echo '
    <div class="col-12">
        <div class="alert alert-warning text-center">
            No products matched your search.
        </div>
    </div>';
}

echo '</div></div>';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>

<?php
include 'footer.php';
?>