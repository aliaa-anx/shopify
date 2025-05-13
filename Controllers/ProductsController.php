<?php
require_once 'DBController.php';
require_once 'C:\xampp\htdocs\security-project\Models\Product.php';
class ProductsController
{

  public function displayProduct(Product $product, $option)
  {
    if ($option === 1) {
      $page = "products.php";
    } else if ($option === 2) {
      $page = "cart.php";
    }else if($option===4){
      $page="search.php";
    } else {
      $page = "save.php";
    }
    $element1 = " <div class=\"box\">
            <form action=\"$page\" method=\"post\">
              <div class=\"image\"><img src=\"" . $product->image . "\" ></div>
              <div class=\"text\">
                <h3>$product->name</h3>
                <p>$product->description</p>
                <small>
                  <s class=\"secondary\">$700</s>
                </small><p>$$product->price</p>
              </div>
              <div class=\"anim\">";

    if ($option === 1 || $option === 4) {
      $element2 = "<button type=\"submit\" name=\"add\">Add to Cart</button>";
    } else if ($option === 2) {
      $element2 = "<button type=\"submit\" name=\"remove\">Remove Item</button>
    <button type=\"submit\" name=\"save\">Save for Later</button>";
    } else {
      $element2 = "<button type=\"submit\" name=\"add\">Add back to Cart</button>";
    }
    $element3 = "</div>
    <input type=\"hidden\" name=\"productId\" value='$product->id'>
    </form>
    </div>";
    echo $element1 . $element2 . $element3;
  }
  public function viewProducts($option, $id)
  {
    $db = new DBController;
    $db->openConnection();
    if ($option === 1) {
      $query = "SELECT * FROM product";
    } else if ($option === 2) {
      $query = "SELECT product.id,product.name,product.color,product.price,product.amount,
      product.productImg,product.description,product.categoryId
       FROM cart INNER JOIN product ON `userId` = $id and product.id = cart.productId";
    } else if($option === 3) {
      $query = "SELECT product.id,product.name,product.color,product.price,product.amount,
      product.productImg,product.description,product.categoryId
       FROM wishlist INNER JOIN product ON `userId` = $id and product.id = wishlist.productId";
      //  CATEGORY VIEW OPTION
    }else
    {
      $query = "SELECT * FROM product WHERE categoryId = $id";
    }
    $result = $db->proccessQuery($query);
    while ($row = mysqli_fetch_assoc($result)) {
      $product = new Product;
      $product->id = $row['id'];
      $product->name = $row['name'];
      $product->color = $row['color'];
      $product->price = $row['price'];
      $product->amount = $row['amount'];
      $product->image = $row['productImg'];
      $product->description = $row['description'];
      $product->categoryId = $row['categoryId'];
      if ($option === 1 || $option === 5) {
        $this->displayProduct($product, 1);
      } else if ($option === 2) {
        $this->displayProduct($product, 2);
      } else if($option === 3) {
        $this->displayProduct($product, 3);
      }else
      {
        
      }
    }
  }
}
