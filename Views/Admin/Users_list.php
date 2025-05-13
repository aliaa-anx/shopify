<?php
require_once 'C:\xampp\htdocs\security-project\Models\Admin.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Admin']);
$userId = $user['id'];
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
      <link rel="stylesheet" href="../assets/css/all.min.css">

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
      <?php include('navbar.php'); ?><br><br><br><BR><BR>



      <div>
        <div class="container">
          <center>
            <form method="post" action="search_user.php">
              <input type=text placeholder="Search" name="keyword" class="Search" style="   border: none;
    padding: 1%;
    background-color: rgba(181, 181, 181, 0.367);
    width:30%;
    border-radius: 5vw;
    font-size: 1.3vw;">
              <select name="choice" required>
                <option value="id">Id</option>
                <option value="name">Username</option>
                <option value="number">Phone Number</option>
                <option value="email">E-mail</option>
              </select>
              <button type="submit" class="submit" name="submit"><img style="padding-top:2%" src="../Assets/images/search.png" width="50px" height="50px"> </button>
            </form>
          </center>



          <?php
          $db = new DBController;
          $db->openConnection();
          $query1 = "SELECT * FROM `user` ";
          $query2 = "SELECT user.id, user.name , COUNT(recordNumber) AS record_count FROM `user` left join records on user.id=userId Group by user.id,user.name";


          $result1 = $db->proccessQuery($query1);
          $result2 = $db->proccessQuery($query2);
          ?>


          <h1>Users List</h1>
          <ceenter>
            <div class="main">
              <center>
                <table>
                  <tr>
                    <th> </th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>E-mail</th>
                    <th>Orders</th>
                    <th>Action</th>
                  </tr>



                  <?php
                  $counter = 0;
                  while ($row = mysqli_fetch_assoc($result1)) {
                    $row2 = mysqli_fetch_assoc($result2);
                    $counter++;
                    $ID = $row['id'];

                    echo ("
      <tr>
      <td><h3>" . $counter . "</h3></td>
      <td><h3>" . $row['id'] . "</h3></td>
      <td><h3>" . $row['name'] . "</h3></td>
      <td><h3>" . $row['number'] . "</h3></td>
      <td><h3>" . $row['email'] . "</h3></td>
      <td><h3>" . $row2['record_count'] . "</h3></td>
      ");

                  ?>
                    <td>
                      <form method="post" action="block_user.php">
                        <input type="hidden" name="userId" value="<?php echo $ID; ?>">

                        <button type="submit" class="submit" name="submit"><img src="block-user.png" width="50px" height="50px"> </button>
                      </form>

                    </td>
              <?php }
               ?>
              </tr>
                </table>
                </cennter>

            </div>
            </center>


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