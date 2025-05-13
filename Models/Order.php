<?php
require_once '../../Controllers/DBController.php';
require_once 'Product.php';
class Order{
  public $orderNum;
  public $userId;
  public $userAddress;
  public $totalPrice;
  public $orderStatus;

  public function savePurchasedProducts($userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "SELECT * FROM cart WHERE userId = $userId";
    $result = $db->proccessQuery($query);
    while($row = mysqli_fetch_assoc($result))
    {
      $productId = $row['productId'];
      $query = "INSERT INTO records (userId, purchasedProductId)
      VALUES ($userId, $productId)";
      $db->proccessQuery($query);
    }
    $db->closeConnection();
  }

  public function deleteOrderProductsFromCart($userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "DELETE FROM cart WHERE userId = $userId";
    $db->proccessQuery($query);
    $db->closeConnection();
  }

  public function decrementProductsAmount($userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "SELECT * FROM cart WHERE userId = $userId";
    $result = $db->proccessQuery($query);
    while($row = mysqli_fetch_assoc($result))
    {
      $product = new Product;
      $productId = $row['productId'];
      $product->decrementAmount($productId);
    }
    $db->closeConnection();
  }
  public function recordOrder(Order $order)
  {
    $userId = $order->userId;
    $userAddress = $order->userAddress;
    $orderPrice = $order->totalPrice;
    $db = new DBController;
    $db->openConnection();
    $query = "INSERT INTO `order` (`userId`, `userAddress`, `orderPrice`) 
    VALUES ($userId, '$userAddress', $orderPrice)";
    $db->proccessQuery($query);
    $this->savePurchasedProducts($userId);
    $this->decrementProductsAmount($userId);
    $this->deleteOrderProductsFromCart($userId);
    $db->closeConnection();
  }
}
?>