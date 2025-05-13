<?php
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Admin']);
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
<!--///////////////////////////////////////////////-->
   <!-- Start Landing -->
   <div class="landing" id="landing">
    <div class="container">
      <div class="text">
        <h2><div>Hello <?php echo $user['name'];?>,</div> Welcome To Our Website <span style="display: block;margin-bottom:10px;">Fashonista</span></h2>
        <p>Hope you are doing well and be very productive at your work today :)</p>
        <div class="button"><a href="Users_list.php">Check Users</a></div>
      </div>
      <div class="imagemove" >
        <!-- <img class="strawberry" src="../assets/images/dress (1).png" alt=""> -->
        <img src="../assets/images/admin-panel.png" alt="">
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