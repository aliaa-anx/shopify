<?php
require_once '../../Controllers/ProductsController.php';
require_once '../../models/searchagent.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Customer']);
?>
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
    <title>Search</title>
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
    <div class="articles searchdiv" id="articles">
      <div class="container">
        <div class="startimage"><img src="../assets/images/fashion.png" alt=""></div>
        <!-- Start products Section -->
        <div class="special-heading" id="cakes">
          <img src="../assets/images/butterflies.png" alt="">
          <h2>Search For Products</h2>
        </div>
        <div class="search">
            <form>
              <input type="text" placeholder="Enter the keyword" class="searchInput" name="query">
              <input type="submit" value="Search" name = "search" class="blackbtn searchbtn">
            </form>
          </div>
        <div class="content">
          <?php
            if (isset($_GET['search'])) {
                $searchQuery = $_GET['query'];
                $agent = searchagent::getInstance();
                $agent->search($searchQuery);
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