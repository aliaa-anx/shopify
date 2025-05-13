<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
  <!-- Start Register -->
  <div class="login">
    <div class="container">
      <div class="box ">
        <h1>Sign-Up</h1>
        <!-- If there's an error sent into the url by 'get' method, this function is gonna print this error -->
        <?php
        if (isset($_GET['error'])) { ?></p>
          <p class="error"> <?php echo $_GET['error']; ?> </p>
        <?php }
        ?>
        <?php
        require_once '../../Controllers/AuthController.php';
        require_once '../../Models/User.php';
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['number'])) {
          $user = new User;
          $user->name = $_POST['name'];
          $user->password = $_POST['password'];
          $user->email = $_POST['email'];
          $user->number = $_POST['number'];
          $auth = new AuthController;
          $auth->register($user);
        }
        ?>
        <!-- method 'post' is more secured than 'get', cuz 'get' shows its content in the url -->
        <form method="Post">
          <label>Username</label>
          <div>
            <i class="fa-solid fa-user"></i>
            <input type="text" placeholder="Username" name="name" autofocus>
          </div>
          <label>Email</label>
          <div>
            <i class="fa-solid fa-envelope"></i>
            <input type="email" placeholder="Email" name="email">
          </div>
          <label>Password</label>
          <div>
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Password" name="password">
          </div>
          <label>Number</label>
          <div>
            <i class="fa-solid fa-phone"></i>
            <input type="number" placeholder="Number" name="number">
          </div>
          <input type="submit" class="submit" name="submit">
        </form>
        <a href="login.php" class="have">Already have an account?</a>
      </div>
    </div>
  </div>
  <!-- End Register -->
  <?php include('../assets/footer.html') ?>
</body>

</html>