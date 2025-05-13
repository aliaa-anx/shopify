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
  <title>Delivery</title>
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
  <!-- Start contact -->
  <div class="deliver">
  <div class="update">
    <div class="container">
    <div class="special-heading" id="cakes">
            <img src="../assets/images/butterflies.png" alt=""><h2>Delivery</h2></div>
      <div class="contact" id="contact">
        <div class="section2">
          <form action="delivery.php" method="post">
          <p class="delivery">Please Fill out this form to be able to deliver your order for you</p>
          <input type="text" placeholder="Enter your Address" name="address" required>
          <select name="delivery_time" >
            <option value="week" checked>Within a Week "For Free"</option>
            <option value="24hours">In 24 Hours "Includes Extra fees"</option>
          </select>
          <input type="submit" value="Submit" name="submit" class="btn">
          <button class="blackbtn" type="button"><a href="cart.php">Back</a></button>
          </form>

        </div>
        <div class="motorcycle">
        <div class="section3">
          <div class="content">
            <div class="image"><img src="../assets/images/delivery-man.png" alt=""></div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- End contact -->
  <?php
    if(isset($_POST['submit'])){
      $address = $_POST['address'];
      $delivery_time = $_POST['delivery_time'];
      $user_id = $user['id'];
      if($delivery_time === "week"){
        $fees = 0;
      }
      else{
        $fees = 20;
      }
      $cart = new Cart;
      $totalPrice = $cart->showTotalPrice($user_id);
      $totalPrice = $totalPrice + $fees;
      setcookie("address", $address, time() + 3600, "/");
      setcookie("totalPrice", $totalPrice , time() + 3600, "/");
      header("Location: credit_card.php");
    }
  ?>
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