<?php 
include 'nav.php';
require 'connect_db.php';
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

.card-img-top {
  height: 200px; 
  object-fit: cover;
}
</style>
</head>


  <body>

<div id="container" class="container mt-4">
    <header>
      <h1 class="main-headerS text-center">Outlet</h1>
      <h5 class="sub-header text-center">Sale ends 31st June 2026</h5>

      </header>

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
		<p class="card-text"><strong>&pound ' . $row['price'] . '</strong></p>
	  </div>
	  <div class="card-footer text-muted">
		<a href="add_to_cart.php?product_id='.$row['product_id'].'" class="btn btn-primary btn-block">Add to Basket</a>
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
	
  include('footer.php');
?>	


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
