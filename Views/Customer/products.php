<?php
require_once '../../Models/Product.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Customer']);
?>
  <!-- Including the function file -->

  <!-- Inserting data (that are sent by the hidden inputs) into the `cart` database -->
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
    <title>Products</title>
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
      <div class="sidebar">
        <?php
        $db = new DBController;
        $db->openConnection();
        $query = "SELECT * FROM `category`";
        $result = $db->proccessQuery($query);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<form>
          <div>
            <input type=\"hidden\" name=\"catId\" value=".$row['id'].">
            <input type=\"submit\" name=\"cat\" value=". $row['name'].">
          </div>
        </form>";
        }
        ?>
      </div>
      <div class="container">
        <div class="startimage"><img src="../assets/images/fashion.png" alt=""></div>
        <!-- Start products Section -->
        <div class="special-heading" id="cakes">
          <img src="../assets/images/butterflies.png" alt="">
          <h2>Products</h2>
        </div>
        <div class="content">
          <?php
          require_once '../../Controllers/ProductsController.php';
          $products = new ProductsController;
          if(isset($_GET['cat']))
        {
          $catId = $_GET['catId'];
          $products->viewProducts(5, $catId);
        }else{
          $products->viewProducts(1, $user['id']);
        }
          ?>
        </div>
        <!-- End products Section -->
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