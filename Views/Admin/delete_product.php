<?php
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Admin']);
?>


<?php
if(isset($_POST['product_id']))
{
    require_once '../../Models/Product.php';
    $product = new Product();
    $product->id = $_POST['product_id'];
    $result = $product->deleteProduct($product->id);
    echo $result;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Delete Product</title>
<!-- Normalize -->
<link rel="stylesheet" href="../assets/css/normalize.css">
<!-- Main CSS File -->
  <!-- Main CSS File -->
  <link rel="stylesheet" href="../assets/css/master.css">
<!-- <link rel="stylesheet" href="../assets/css/master.css"> -->
<link rel="stylesheet" href="admin.css">
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
<div class="admin container">
    <br>
    <br>
    <br>
    <br>
    <br>
    <h2>Delete Product </h2>
    <?php
    require_once '../../Models/Product.php';
    $product = new Product();
    $products = $product->displayProducts();
    ?>
    <?php foreach($products as $row){?>
    <form action="delete_product.php" method="post">
        <div class="product_row">
            <span class="product-id"><?php echo $row['id']?></span>
            <span class="product-name"><?php echo $row['name'];?></span>
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="delete-button">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </form>
    <?php }?>
</div>
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