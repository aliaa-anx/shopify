<?php
require_once '../../Controllers/ProductsController.php';
require_once '../../Models/Cart.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Customer']);
?>



<!-- Delete Item -->
<?php
    if (isset($_POST['remove'])) {
      //every product has the id of its user, just to make separate carts for different users
      $userId = $user['id'];
      $productId = $_POST['productId'];
      $product = new Product;
      $product->removeFromCart($productId,$userId);
      echo "
        <script> alert('Item is removed successfully') </script>
        ";
    }
    // Saving Item into `save` database
    else if (isset($_POST['save'])) {
      //every product has the id of its user, just to make separate carts for different users
      $userId = $user['id'];
      $productId = $_POST['productId'];
      $product = new Product;
      $product->addToWishlist($productId,$userId);
      echo "
        <script> alert('Item is Saved successfully') </script>
        ";
    }
    
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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
    <div class="articles">
        <div class="container">
        <div class="startimage"><img src="../assets/images/fashion.png" alt=""></div>
          <div class="special-heading" >
            <img src="../assets/images/butterflies.png" alt=""><h2>Cart</h2></div>
          <div class="content">
            <!-- Start cart -->
            <!-- displays elements in `cart` database & printing the price -->
            <?php
            $userId=  $user['id'];
            $productController = new ProductsController;
            $productController->viewProducts(2, $userId);
            // calculating the total price to be able to record it in the database when payment
            $cart = new Cart;
            $totalPrice = $cart->showTotalPrice($userId);
          ?>
        </div>
                <div class="cartbtn">
                  <button class="blackbtn"><a href="save.php">View Saved Items ?</a></button>
                  <button class="blackbtn"><a href="delivery.php">Proceed to Pay
                  <span style="color: rgb(255 180 255);"><?php echo "$$totalPrice"?></span></a></button>
                </div>
        </div>
        </div>
    </div>
  <!-- End cart -->
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