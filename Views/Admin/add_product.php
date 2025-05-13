<?php
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Admin']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product</title>
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
<div class=" admin container">
    <br>
    <br>
    <br>
    <br>
    <br>
    <h2>Add Product</h2>
    <?php
    if (isset($_GET['error'])) { ?></p>
    <p class="error"> <?php echo $_GET['error']; ?> </p>
    <?php }
    ?>

    <?php
    require_once ('../../Models/Product.php');
    if (isset($_POST['name']) && isset($_POST['color']) && isset($_POST['categoryid']) && isset($_POST['price']) && isset($_POST['amount']) && isset($_POST['description']) && isset($_POST['image'])) {
    $product = new product();
    $product->name = $_POST['name'];
    $product->color = $_POST['color'];
    $product->categoryId = $_POST['categoryid'];
    $product->price = $_POST['price'];
    $product->amount = $_POST['amount'];
    $product->description = $_POST['description'];
    $product->image = $_POST['image'];
    $msg = $product->addProduct($product);
    echo $msg;
    }
    ?>
    <form action="add_product.php" method="post" class="add_product">
    <input type="text" name="name" placeholder="Name" ><br>
    <input type="text" name="color" placeholder="Color" ><br>
    <input type="number" name="categoryid" placeholder="Category Number" ><br>
    <input type="number" name="price" placeholder="Price" ><br>
    <input type="number" name="amount" placeholder="Amount"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="file" name="image" accept="image/*" ><br>
    <input type="submit" value="Add">
    </form>
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