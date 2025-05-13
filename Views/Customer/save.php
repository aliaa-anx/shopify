<?php
require_once '../../Controllers/ProductsController.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Customer']);
?>



<!-- Add Item back to `cart` database-->
<?php
    if (isset($_POST['add'])) {
      $userId = $user['id'];
      $productId = $_POST['productId'];
      $product = new Product;
      $product->addBackToCart($productId,$userId);
      echo "
      <script> alert('Item has been added back to your cart successfully') </script>
      ";
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Save For Later</title>
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
            <img src="../assets/images/butterflies.png" alt=""><h2>Saved Items</h2></div>
          <div class="content">
            <!-- Start cart -->
            <!-- Displaying product in `save` database -->
            <?php
            $userId = $user['id'];
            $productController = new ProductsController;
            $productController->viewProducts(3, $userId);
          ?>
        </div>
        <button class="blackbtn"><a href="cart.php">Go back to Cart ?</a></button>
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