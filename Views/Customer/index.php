<?php
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Customer']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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
</head>
<body>
    <?php include('navbar.php') ?>
   <!-- Start Landing -->
   <div class="landing" id="landing">
    <div class="container">
      <div class="text">
        <h2><div>Hello <?php echo htmlspecialchars($user['name']); ?>,</div> Welcome To Our Website <span style="display: block;margin-bottom:10px;">Fashonista</span></h2>
        <p>Here we are not only sharing our fashionable items, we are also sharing happinnes with them, Be happy and Smile :)</p>
        <div class="button"><a href="products.php">See Our Products</a></div>
        <?php
        try {
          require_once '../../Controllers/DBController.php';
          $db = new DBController;
          if (!$db->openConnection()) {
              throw new Exception("Database connection failed");
          }
          
          $userId = (int)$user['id'];
          $query = "SELECT count(*) FROM records WHERE userId = ?";
          
          $stmt = $db->getConnection()->prepare($query);
          if (!$stmt) {
              throw new Exception("Prepare failed: " . $db->getConnection()->error);
          }
          
          if (!$stmt->bind_param("i", $userId) || !$stmt->execute()) {
              throw new Exception("Execute failed: " . $stmt->error);
          }
          
          $result = $stmt->get_result();
          $num = $result->fetch_array();
          
          if($num[0] != 0) {
              echo '<div class="button"><a href="recommendations.php">Recommended For You</a></div>';
          }
          
          $stmt->close();
          $db->closeConnection();
          
      } catch (Exception $e) {
          error_log("Database error in index.php: " . $e->getMessage());
          // Continue rendering page even if recommendations fail
      }
        ?>
      </div>
      <div class="imagemove" >
        <img class="strawberry" src="../assets/images/dress (1).png" alt="">
        <img src="../assets/images/mannequin.png" alt="">
      </div>
    </div>
    <a href="#articles"><img src="images/rose.png" alt=""></a>
  </div>
  <!-- End Landing -->
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
