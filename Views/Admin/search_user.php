<?php
require_once 'C:\xampp\htdocs\security-project\Models\Admin.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Admin']);
    $db = new DBController;
    $db->openConnection();

?>

      
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <!-- Normalize -->
  <link rel="stylesheet" href="../assets/css/normalize.css">
  <!-- Main CSS File -->
  <link rel="stylesheet" href="../assets/css/master.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../assets/css/Admin.css">
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>
<body>
<?php include('navbar.php');?><br><br>
<h1>Search Results</h1>
<ceenter><div class="main">
  <center>
<table>
  <tr>
    <th> </th> 
    <th>ID</th> 
    <th>Name</th> 
    <th>Phone Number</th>
    <th>E-mail</th>
    <th>Action</th>
  </tr>  

<?php
  if (isset($_POST['submit'])) {
    $keyword = $_POST['keyword'];
    $filterType = $_POST['choice'];

    $db = new DBController;
    $db->openConnection();
    $query = "SELECT * FROM `user` WHERE $filterType = '$keyword'  ";
    $result= $db->proccessQuery($query);
    $counter=0;
   while ($row = mysqli_fetch_assoc($result)) {
   $counter++;
      echo("
      <tr>
      <td><h3>".$counter."</h3></td>
      <td><h3>".$row['id']."</h3></td>
      <td><h3>".$row['name']."</h3></td>
      <td><h3>".$row['number']."</h3></td>
      <td><h3>".$row['email']."</h3></td>");
      ?>
      <td>
        <form method="post" action="block_user.php">
        <input type="hidden" name="userId" value= "<?php echo $row['id'] ;?>">

        <button type="submit" class="submit" name="submit" ><img src="block-user.png" width="50px" height="50px"> </button>
        </form>

      </td>
      
    </tr> 
    <?php } ?>
   </TABLE>
   </div></center>

   <?PHP include('../assets/footer.html'); ?>

</body>
</html>
<?php
   

  }
  $db->closeConnection();
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>