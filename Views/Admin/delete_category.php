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
    <title>Delete Category</title>
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
<?php
    require_once '../../Models/Category.php';
    $category = new Category();
    $categories = $category->displayCategories();
    ?>    
    <div class="admin container">
        <div class="content">
            <br>
            <br>
            <br>
            <br>
        <h2>Delete Category</h2>
        <?php foreach ($categories as $row) { ?>
            <form action="delete_category.php" method="post">
                <div class="category-row">
                    <span class="category-name"><?php echo $row['name']; ?></span>
                    <input type="hidden" name="category_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="delete-button"> 
                        <i class="fa-solid fa-trash"></i>
                    </button> 
                </div>
            </form>
        <?php } ?>
        </div>
    </div>
</body>
<?php include('../assets/footer.html'); ?>
</html>
<?php
if(isset($_POST['category_id']))
{
    require_once '../../Models/Category.php';
    $category = new Category();
    $category->id = $_POST['category_id'];
    $result = $category->deleteCategory($category->id);
    echo $result; 
}
?>
<?php
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>