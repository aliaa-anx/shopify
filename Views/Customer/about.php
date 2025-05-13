<?php
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Customer']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About</title>
   <!-- Normalize -->
   <link rel="stylesheet" href="../assets/css/normalize.css">
   <!-- Main CSS File -->
   <link rel="stylesheet" href="../assets/css/master.css">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="../assets/css/all.min.css">
   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
   <link rel="preconnect" href="https://fonts.googleapis.com">
 <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
 <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>
<body>
<?php include('navbar.php')?>
  <!-- Start About -->
  <div class="about" id="About">
    <div class="container">
      <img class="side" src="images/Sweet Treats Logo Design_ Strawberry Chocolate Logo_ CakePops Logo Design_ Valentines Day Sweets Logo_ Custom Logo(JPG).jpg" alt="">
      <div class="special-heading" >
        <img src="../assets/images/butterflies.png" alt=""><h2>About</h2></div>
    <div class="row">
      <div class="col">
        <ul>
          <h1>Why to choose us?</h1>
          <li>Shipping & Returns</li>
          <li>Secure Shopping</li>
          <li>Online Support</li>
          <li>Order Protection</li>
          <li>Discount 15%</li>
        </ul>
        <button class="blackbtn" type="button">Learn More</button>
      </div>
      <div class="col">
        <div class="vid">
          <video src="../assets/video/vid1.mp4" autoplay muted loop></video>
        </div>
      </div>
    </div>
    </div>
    </div>
    <!-- End About -->
    <?php include('../assets/footer.html')?>
</body>
</html>
<?php
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>