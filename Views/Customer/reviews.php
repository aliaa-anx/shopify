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
  <title>Reviews</title>
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
<?php include('navbar.php')?>
  <!-- Start Testimonials -->
  <div class="testim" id="testimonials">
    <div class="container">
      <div class="special-heading" >
        <img src="../assets/images/butterflies.png" alt=""><h2>Reviews</h2></div>
      <div class="content">
        <div class="person">
          <div class="image"><img src="../assets/images/avatar-01.png" alt=""></div>
          <div class="text">
            <h3>Mohamed Farag</h3>
            <span class="title">Full Stack Developer</span>
            <div class="stars">
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est natus quaerat ducimus</p>
          </div>
        </div>
        <div class="person">
          <div class="image"><img src="../assets/images/avatar-02.png" alt=""></div>
          <div class="text">
            <h3>Mohamed Ibrahim</h3>
            <span class="title">Full Stack Developer</span>
            <div class="stars">
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est natus quaerat ducimus</p>
          </div>
        </div>
        <div class="person">
          <div class="image"><img src="../assets/images/avatar-03.png" alt=""></div>
          <div class="text">
            <h3>Shady Nabil</h3>
            <span class="title">Full Stack Developer</span>
            <div class="stars">
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est natus quaerat ducimus</p>
          </div>
        </div>
        <div class="person">
          <div class="image"><img src="../assets/images/avatar-04.png" alt=""></div>
          <div class="text">
            <h3>Amr Hendawy</h3>
            <span class="title">Full Stack Developer</span>
            <div class="stars">
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est natus quaerat ducimus</p>
          </div>
        </div>
        <div class="person">
          <div class="image"><img src="../assets/images/avatar-05.png" alt=""></div>
          <div class="text">
            <h3>Sherief Ashraf</h3>
            <span class="title">Full Stack Developer</span>
            <div class="stars">
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="far fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est natus quaerat ducimus</p>
          </div>
        </div>
        <div class="person">
          <div class="image"><img src="../assets/images/avatar-06.png" alt=""></div>
          <div class="text">
            <h3>Osama Mohamed</h3>
            <span class="title">Full Stack Developer</span>
            <div class="stars">
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="filled fas fa-star"></i>
              <i class="far fa-star"></i>
              <i class="far fa-star"></i>
            </div>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est natus quaerat ducimus</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Testimonials -->
  <?php include('../assets/footer.html')?>
</body>
</html>
<?php
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>