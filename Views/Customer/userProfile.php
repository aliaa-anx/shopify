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
    <title>Home</title>
    <!-- Normalize -->
    <link rel="stylesheet" href="../assets/css/normalize.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="../assets/css/master.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
  </head>

  <body>
    <?php include('navbar.php') ?>
    <!-- Start Landing -->
    <div class="landing profile" id="landing">
      <div class="container">
        <div class="info">
          <div><img src="../assets/images/profile.png" alt=""></div>
          <ul>
            <li>Username : <?php echo $user['id']?></li>
            <li>Number of Purchased Items : 
              <?php 
                require_once '../../Models/Customer.php';
                $count = Customer::numOfPurchasedProducts($user['id']);
                echo $count;
            ?></li>
          </ul>
        </div>
        <div class="text">
          <div class="chart"><img src="../assets/images/pencil.png" alt=""></div>
          <div class="button profilebtn"><a href="update_password.php">Update passsword</a></div>
          <div class="button profilebtn"><a href="update_username.php">Update username</a></div>
        </div>
      </div>
      <a href="#articles"><img src="images/rose.png" alt=""></a>
    </div>
    <!-- End Landing -->
    <?php include('../assets/footer.html'); ?>
  </body>

  </html>

  <?php
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>