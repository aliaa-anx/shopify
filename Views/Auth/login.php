<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
</head>
<body>
<?php include('navbarLogin.php') ?>
  <!-- Start Login -->
  <div class="login">
    <div class="container">
      <div class="box">
        <h1>Login</h1>

        <?php
      if (isset($_GET['error'])) { ?></p>
        <p class="error"> <?php echo $_GET['error']; ?> </p>
      <?php }
      ?>

      <?php
      require_once '../../Controllers/AuthController.php';
      require_once '../../Models/User.php';
      if (isset($_POST['name']) && isset($_POST['password']))
      {
        $user = new User;
        $user->name = $_POST['name'];
        $user->password = $_POST['password'];
        $auth = new AuthController ;
        $auth->login($user);
      }
      ?>

        <form method="post">
          <label>Username</label>
          <div>
            <i class="fa-solid fa-user"></i>
          <input type="text" placeholder="Username" name="name" autofocus>
          </div>
          <label>Password</label>
          <div>
            <i class="fa-solid fa-lock"></i>
          <input type="password" placeholder="Password" name="password" >
          </div>
          <a href="#" class="forgot">Forgot Password?</a>
          <input type="submit" class="submit" name="submit">
        </form>
        <a href="register.php" class="signup">Sign-up</a>
      </div>
    </div>
    </div>
  <!-- End Login -->
  <?php include('../assets/footer.html')?>
</body>
</html>