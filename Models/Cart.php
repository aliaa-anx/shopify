<?php
require_once 'C:\xampp\htdocs\security-project\Controllers\DBController.php';
class Cart{
  public $userId;
  public $productId;

  public function showNumOfItems($userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "SELECT * FROM cart WHERE userId='$userId' ";
    $result = $db->proccessQuery($query);
    $db->closeConnection();
    return mysqli_num_rows($result);
  }

  public function showTotalPrice($userId)
  {
    $totalPrice = 0;
    $db = new DBController;
    $db->openConnection();
    $query = "SELECT price FROM cart INNER JOIN product ON product.id = cart.productId and userId = $userId";
    $result = $db->proccessQuery($query);
    while($row = mysqli_fetch_assoc($result))
    {
      $totalPrice = $totalPrice + $row['price'];
    }
    return $totalPrice;
  }
}
?>