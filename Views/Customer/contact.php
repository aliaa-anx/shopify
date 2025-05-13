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
  <title>Contact Us</title>
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
  <div class="contact" id="contact">
    <div class="section1">
      <div class="content">
        <h2>Your opinion is important</h2>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Excepturi asperiores consectetur, recusandae ratione provident necessitatibus, cumque delectus commodi fuga praesentium beatae. Totam vel similique laborum dicta aperiam odit doloribus corporis.</p>
        <div class="image"><img src="../assets/images/fashion.png" alt=""></div>
      </div>
    </div>
    <div class="section2">
      <h2>Feedback</h2>
      <form action="contact.php" method="post">
        <input type="text" placeholder="Your Name" name="name" required>
        <input type="email" placeholder="Your Email" name="email" required>
        <input type="number" placeholder="Your Phone" name="number" required>
        <textarea name="message" id="" cols="30" rows="10"placeholder="Tell Us About Your Needs"></textarea>
        <input type="submit" value="Send" name="submit" class="btn">
      </form>
    </div>
  </div>
  <!-- End contact -->
  <?php
    require_once '../../Models/Customer.php';
    if(isset($_POST['submit'])){
      $customer = new Customer;
      $customer->id = $user['id'];
      $customer->name = $_POST['name'];
      $customer->email = $_POST['email'];
      $customer->number = $_POST['number'];
      $msg= $_POST['message'];
      Customer::sendFeedback($customer,$msg);
      echo "
      <script> alert('Your Feedback had been Sent Successfully') </script>
      ";
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