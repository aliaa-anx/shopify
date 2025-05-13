<?php
require_once 'C:\xampp\htdocs\security-project\Models\Admin.php';
require_once __DIR__ . '/../../Controllers/Middleware.php';
use Controllers\Middleware;
try {
$user = Middleware::authorize(['Admin']);
    $db = new DBController;
    $db->openConnection();

?>

 <?php
  if (isset($_POST['submit'])) {
    $userId = $_POST['userId'];
    Admin::BlockUser($userId);
    echo $msg;
    echo "<script> alert('User is Blocked successfully') </script>";
    header('Location:Users_list.php');
  }
  $db->closeConnection();
}catch (Exception $e) {
  error_log("Authorization error in about.php: " . $e->getMessage());
  header("Location: ../Auth/login.php");
  exit();
}
?>