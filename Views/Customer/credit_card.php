<?php
require_once '../../Controllers/DBController.php';
require_once '../../Models/Order.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';

use Controllers\Middleware;

try {
  $user = Middleware::authorize(['Customer']);
  if (isset($_COOKIE['address'])) {
?>

    <?php
    if (isset($_POST['submit'])) {
      $user_id = $user['id'];
      $card_num = $_POST['card_num'];
      $expiry_date = $_POST['date'];
      $card_cvv = $_POST['cvv'];
      $db = new DBController;
      $db->openConnection();
      $query = "SELECT * FROM `creditcard` WHERE `cardNumber`='$card_num' AND `cardCvv`='$card_cvv'";
      $result = $db->proccessQuery($query);
      $row = mysqli_fetch_assoc($result);
      if ($row['cardNumber'] == $card_num && $row['cardCvv'] == $card_cvv) {
        $address = $_COOKIE['address'];
        $totalPrice = $_COOKIE['totalPrice'];
        $order = new Order;
        $order->userId = $user_id;
        $order->userAddress = $address;
        $order->totalPrice = $totalPrice;
        $order->recordOrder($order);
        $db->closeConnection();
        setcookie("address", "", time() - 3600, "/");
        setcookie("totalPrice", "", time() - 3600, "/");
        echo "
      <script> alert('Your order had been purchased succsessfully') </script>
      ";
        header("Location: index.php");
      } else {
        header("Location: credit_card.php?error=Incorrect Card Number or CVV");
      }
    }
    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Credit Card</title>
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
      <?php include('navbar.php') ?>
      <!-- Start contact -->
      <div class="update">
        <div class="container">
          <div class="special-heading" id="cakes">
            <img src="images/butterflies.png" alt="">
            <h2>Payment</h2>
          </div>
          <div class="contact" id="contact">
            <div class="section2">
              <form action="credit_card.php" method="post">
                <?php
                if (isset($_GET['error'])) { ?></p>
                  <p class="error"> <?php echo $_GET['error']; ?> </p>
                <?php }
                ?>
                <label>Full Name</label>
                <input type="text" name="name" required>
                <label>Card Number</label>
                <input type="tel" name="card_num" required>
                <label>CVV</label>
                <input type="tel" name="cvv" required>
                <label>Expiration Date</label>
                <input type="date" name="date" required>
                <input type="submit" name="submit" value="Enroll" class="btn">
              </form>
            </div>
            <div class="section3">
              <div class="content">
                <div class="image"><img src="../assets/images/secure-payment.png" alt=""></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End contact -->
      <?php include('../assets/footer.html') ?>
    </body>

    </html>
<?php
  } else {
    header("Location: delivery.php");
  }
} catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>