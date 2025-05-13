<?php
require_once 'C:\xampp\htdocs\security-project\Models\Product.php';
require_once '../../Controllers/ProductsController.php';
require_once '../../Models/Product.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Customer']);
?>
  <!-- Including the function file -->

  <!-- Inserting data (that are sent by the hidden inputs) into the cart database -->
  <?php
  if (isset($_POST['add'])) {
    $userId = $user['id'];
    $productId = $_POST['productId'];
    $product = new Product;
    $msg = $product->addToCart($productId, $userId);
    echo $msg;
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Products</title>
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  </head>

  <body>
    <?php include('navbar.php') ?>
    <!-- Start Articles -->
    <div class="articles" id="articles">
      <div class="container">
        <div class="startimage"><img src="../assets/images/fashion.png" alt=""></div>
        <!-- Start recommended products Section -->
        <div class="special-heading" id="cakes">
          <img src="../assets/images/butterflies.png" alt="">
          <h2>Recommended Products</h2>
        </div>
        <div class="content">
          <?php
          $userId = $user['id'];
          $db = new DBController;
          $db->openConnection();
          $query1 = "SELECT DISTINCT  categoryId FROM records INNER JOIN product
          ON `userId` = $userId and product.id = records.purchasedproductid";
          $result = $db->proccessQuery($query1);
          while ($row = mysqli_fetch_assoc($result)) {
            $catId = $row['categoryId'];
            $query2 = "SELECT id,`name`,price,productImg,`description`
                FROM product WHERE categoryId = $catId";
            $result2 = $db->proccessQuery($query2);
            $productControl = new ProductsController;
            $product = new Product;
            while ($row2 = mysqli_fetch_assoc($result2)) {
              $product->name = $row2['name'];
              $product->image = $row2['productImg'];
              $product->id = $row2['id'];
              $product->price = $row2['price'];
              $product->description = $row2['description'];
              $productControl->displayProduct($product, 1);
            }
          }
          ?>
        </div>
        <!-- End recommended products Section -->
      </div>
    </div>
    <!-- End Articles -->
    <?php include('../assets/footer.html') ?>
  </body>

  </html>
  <?php
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>