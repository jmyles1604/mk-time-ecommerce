<?php 
include 'nav.php';
require 'connect_db.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MK Time</title>

  
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Alegreya SC' rel='stylesheet'>

  

  <style>

h1 {
	font-size: 300%;	
}

h1, h2 {
	color: rgb(1, 54, 1);
	text-transform: uppercase;
	font-weight: 100;
    text-align: center;
}

img {
	width: 100%;
}

#container {
	width: 60%;
	margin: auto;
}
h5 {
  text-align: center;
}

    p {
	color: rgb(1, 54, 1);
	font-weight: 100;
    text-align: center;
}


    </style>
</head>

<body>

  <div id="container" class="container mt-4">
    <header>
    <h2>MK Time <small class="text-muted"><em>Precision, Elegance, and Craftsmanship</em></small></h2>

    <h5><strong>Discover the art of Swiss watchmaking in the heart of Edinburgh.</strong></h5>
    <p>At MK Time, we pride ourselves on offering exquisitely designed and meticulously crafted timepieces, combining timeless style with exceptional quality. 
       Every watch we sell is backed by our guarantee of service and repair,
       ensuring that your investment keeps perfect time for years to come.
       Discover our latest watches.
       Explore our collection on a website designed to shine on any device, bringing our unique designs and elegant craftsmanship directly to you. 
       Whether you’re a seasoned collector or searching for the perfect statement piece, MK Time is dedicated to delivering sophistication, reliability, and style.</p>


      <img src="images/watchface.jpg" class="img-fluid mb-3" alt="watches">

    </header>

</div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>

<?php
include 'footer.php';
?>