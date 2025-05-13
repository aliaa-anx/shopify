
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
  <title>Update Password</title>
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
  <div class="update">
    <div class="container">
    <div class="special-heading" id="cakes">
            <img src="images/butterflies.png" alt=""><h2>Update Your Username</h2></div>
      <div class="contact" id="contact">
        <div class="section2">
          <form action="update_username.php" method="post">
          <?php
          if (isset($_GET['error'])) { ?></p>
          <p class="error"> <?php echo $_GET['error']; ?> </p>
          <?php }
          ?>
            <input type="password" placeholder="Password" name="oldpass" required>
            <input type="text" placeholder="New Username" name="newUsername" required>
            <input type="text" placeholder="Confirm New Username" name="confirmNewUsername"required>
            <input type="submit" name="update" value="Update" class="btn">
          </form>
        </div>
        <div class="section3">
          <div class="content">
            <div class="image"><img src="../assets/images/password (2).png" alt=""></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End contact -->

  <?php
    if(isset($_POST['update'])){
      $user_id = $user['id'];
      $old_pass = $_POST['oldpass'];
      $newUsername = $_POST['newUsername'];
      $confirmNewUsername = $_POST['confirmNewUsername'];
      //checks if there is an empty fleid
      require_once '../../Models/Customer.php';
      $msg = Customer::updateUsername($user_id, $old_pass, $newUsername, $confirmNewUsername);
      echo $msg;
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