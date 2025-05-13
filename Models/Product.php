<?php
require_once 'C:\xampp\htdocs\security-project\Controllers\DBController.php';
require_once 'C:\xampp\htdocs\security-project\Controllers\AuthController.php';
class Product
{
  public $id;
  public $name;
  public $categoryId;
  public $price;
  public $color;
  public $amount;
  public $description;
  public $image;

  public function addToCart($productId, $userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "SELECT amount FROM product WHERE id = $productId";
    $result = $db->proccessQuery($query);
    $row = mysqli_fetch_assoc($result);
    $amount = $row['amount'] + 0;
    if ($amount === 0) {
      return "<script> alert('Unfortunately this product is out of stock, so we can\'t add it into your cart :(') </script>";
    } else {
      $query1 = "SELECT * FROM cart WHERE userId = $userId and productId = $productId";
      $result = $db->proccessQuery($query1);
      if ($row = mysqli_fetch_assoc($result)) {
        $db->closeConnection();
        return "<script> alert('Item has already been added to your cart before!') </script>";
      } else {
        $query3 = "INSERT INTO cart (userId, productId)
      VALUES ('$userId','$productId')";
        $db->proccessQuery($query3);
        $db->closeConnection();
        return "<script> alert('Item has been added to your cart successfully') </script>";
      }
    }
  }

  public function addToWishlist($productId, $userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "INSERT INTO wishlist (userId, productId)
    VALUES ('$userId','$productId')";
    $db->proccessQuery($query);
    $db->closeConnection();
    $this->removeFromCart($productId, $userId);
  }

  public function addBackToCart($productId, $userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "DELETE FROM `wishlist` WHERE `userId` = '$userId' and `productId` = '$productId' ";
    $db->proccessQuery($query);
    $this->addToCart($productId, $userId);
    $db->closeConnection();
  }

  public function removeFromCart($productId, $userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "DELETE FROM `cart` WHERE `userId` = '$userId' and `productId` = '$productId' ";
    $db->proccessQuery($query);
    $db->closeConnection();
  }

  public function decrementAmount($productId)
  {
    $db = new DBController;
    $db->openConnection();
    $query1 = "SELECT amount FROM product WHERE id = $productId";
    $result = $db->proccessQuery($query1);
    $amount = mysqli_fetch_assoc($result);
    $amount = $amount['amount'] - 1;
    $query2 = "UPDATE product SET amount = $amount WHERE id = $productId";
    $db->proccessQuery($query2);
    $db->closeConnection();
  }


  public function validate($data)
  {
    $auth = new AuthController();
    return $auth->validate($data);
  }


  // FOR THE ADMIN
  public function addProduct(Product $product)
  {
    
    $name = $this->validate($product->name);
    $color = $this->validate($product->color);
    $categoryId = $this->validate($product->categoryId);
    $price = $this->validate($product->price);
    $amount = $this->validate($product->amount);
    $description = $this->validate($product->description);
    $productImg = $this->validate($product->image);

    if (empty($name)) {
      header("Location: manage_product.php?error=Product Name is required");
      exit();
    } elseif (empty($color)) {
      header("Location: manage_product.php?error=Product Color is required");
      exit();
    } elseif (empty($categoryId)) {
      header("Location: manage_product.php?error=Product Color is required");
      exit();
    } elseif (empty($price)) {
      header("Location: manage_product.php?error=Product Color is required");
      exit();
    } elseif (empty($amount)) {
      header("Location: manage_product.php?error=Product Color is required");
      exit();
    } elseif (empty($description)) {
      header("Location: manage_product.php?error=Product Color is required");
      exit();
    } elseif (empty($productImg)) {
      header("Location: manage_product.php?error=Product Color is required");
      exit();
    } else {
      $productImg = "../assets/images/" . $productImg;
      $db = new DBController;
      $db->openConnection();
      $query1 = "SELECT * FROM category WHERE id = '$product->categoryId'";
      $result = $db->proccessQuery($query1);
      if (mysqli_fetch_assoc($result)) {
        $query2 = "INSERT INTO `product` (`name`, `color`, `categoryId`, `price`, `amount`, `description`, `productImg`) 
          VALUES ('$name', '$color', '$categoryId', '$price', '$amount', '$description', '$productImg')";
        $db->proccessQuery($query2);
        $db->closeConnection();
        return "<script> alert('Product has been added successfully') </script>";
      } else {
        return "<script> alert('There is no such category') </script>";
      }
    }
  }

  public function deleteProduct($id)
  {
    $db = new DBController;
    $db->openConnection();
    $query2 = "DELETE FROM product where id =$id";
    $db->proccessQuery($query2);
    $db->closeConnection();
    return "<script> alert('Product has been deleted successfully') </script>";
  }

  public function displayProducts()
  {
    $db = new DBController;
    $db->openConnection();
    $query = "SELECT id, name FROM product";
    $result = $db->proccessQuery($query);
    $products = array();
    while($row = mysqli_fetch_assoc($result))
    {
      $products[] = $row;
    }
    $db->closeConnection();
    return $products;
  }

}
