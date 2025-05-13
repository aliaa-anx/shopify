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
    <title>Manage Category</title>
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
    <div class="content">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
        <h2>Add Category</h2>
        <?php
        require_once '../../Models/Category.php';
        if (isset($_POST["name"])) {
            $category = new Category();
            $category->name = $_POST["name"];
            $msg = $category->addCategory($category);
            echo $msg;
        }
        ?>
        <form action="add_category.php" method="post">
            <input type="text" name="name" placeholder="Enter Category Name"><br>
            <input type="submit" value="Add">
        </form>
    </div>
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