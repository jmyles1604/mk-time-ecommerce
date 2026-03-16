<?php
session_start();
include 'nav.php';

if (isset($_SESSION['flash_message'])) {
  echo '
  <div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      '.$_SESSION['flash_message'].'
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  </div>';
  
  unset($_SESSION['flash_message']);
}

// If not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
exit();
}
?>
<div class="container mt-4">
  <h2>Welcome, <?= htmlspecialchars($_SESSION['first_name'] ?? 'User') ?> 👋</h2>
  <p>You are logged in and can view this page.</p>
</div>

<header>
      <h1 class="main-header text-center">Members Only</h1>

    </header>
      <div class="container py-4">
      <h2 class="mb-3">Member Products</h2>

<?php

	# Open database connection.
	require ( 'connect_db.php' );
	echo '<div class="container">
			<div class="row">';	
	# Retrieve items from 'products' database table.
	$q = "SELECT * FROM products WHERE product_id IN (5,6,7,8)" ;
	$r = mysqli_query( $link, $q ) ;
	if ( mysqli_num_rows( $r ) > 0 )
	{
	
	
	while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ))
	{
	echo '
    <div class="col-md-3 d-flex justify-content-center">
	 <div class="card" style="width: 18rem;">
	  <img src="'. $row['image_url'].'" class="card-img-top" alt="'. $row['name'].'">
	   <div class="card-body text-center">
		<h5 class="card-title">'. $row['name'].'</h5>
		<p class="card-text">'. $row['description'].'</p>
	 </div>
	  <div class="card-footer bg-transparent border-dark text-center">
		<p class="card-text">&pound '. $row['price'].'</p>
	  </div>
	  <div class="card-footer text-muted">
		<a href="add_to_cart.php?product_id='.$row['product_id'].'" class="btn btn-primary btn-block">Add to Cart</a>
	   </div>
	  </div>
	</div>  
	' ;
	}
	# Close database connection.
	mysqli_close( $link) ; 
	}
	# Or display message.
	else { echo '<p>There are currently no items in the table to display.</p>
	' ; }
	
?>	

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MK Time</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
        crossorigin="anonymous">

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Alegreya SC' rel='stylesheet'>
 
  </head>

  <style>

.card-img-top {
  height: 200px; 
  object-fit: cover;
}

.h2 {
  font-family: 'Alegreya SC', serif;
  text-align: center;
  }

.p {
  font-family: 'Alegreya SC', serif;
  text-align: center;
  }

</style>

<?php
include 'footer.php';
?>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>

<?php