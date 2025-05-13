<?php
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Admin']);
$userId = $user['id'];;
?>
<!-- Start Header -->
<header>
  <div class="container">
    <div class="logo">
      <img src="../assets/images/woman.png" alt="">Fashonista
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="../Admin/Users_list.php">Users list</a></li>
        <li><a href="../Admin/add_product.php">Add Product</a></li>
        <li><a href="../Admin/delete_product.php">Delete Product</a></li>
        <li><a href="../Admin/add_category.php">Add Category</a></li>
        <li><a href="../Admin/delete_category.php">Delete Category</a></li>
        <li><a href="#" class="user"> <i class="fa fa-user"></i><span><?php echo $user['name']; ?></span></a></li>
        <li><a href="../Auth/logout.php" title="Logout?"><i class="fa-solid fa-right-from-bracket"></i></a></li>
      </ul>
    </nav>
  </div>
</header>
<!-- End Header -->
<?php
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>