<?php
require_once 'C:\xampp\htdocs\security-project\Controllers\DBController.php';
require_once 'C:\xampp\htdocs\security-project\Controllers\productsController.php';
require_once 'C:\xampp\htdocs\security-project\models\product.php';

class searchagent
{

    private static  $thesearchagent;
    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$thesearchagent)) {
            self::$thesearchagent = new searchagent();
        }
        return self::$thesearchagent;
    }

    public function search($searchQuery)
    {
        $db = new dbController;
        $db->openConnection();
        $searchWords = explode(' ', $searchQuery); //searchQuery="blue jeans">>["blue","jeans"]
        $searchWords = array_map('strtolower', $searchWords); // Convert search words to lowercase//make each word into lower case to compare

        // Construct WHERE clause for each search word in the description
        $descriptionConditions = []; //make array of the condition that will be used in the query 
        foreach ($searchWords as $word) {
            $descriptionConditions[] = "LOWER(p.description) LIKE '%$word%'"; //compare description to each word
        }

        // Combine all conditions with OR operator to be used in the query
        $descriptionCondition = '(' . implode(' OR ', $descriptionConditions) . ')'; //if we have two words in search query then we will have two conditions

        // Construct the SQL query
        //left join to make sure it prints all the products although it won't really mater here
        $query = "SELECT DISTINCT p.*
                FROM product p
                LEFT JOIN category c ON p.categoryId = c.id
                WHERE LOWER(p.name) LIKE '%$searchQuery%' 
                    OR LOWER(p.color) LIKE '%$searchQuery%' 
                    OR LOWER(c.name) LIKE '%$searchQuery%' 
                    OR p.price LIKE '%$searchQuery%'
                    OR $descriptionCondition";

        $result = $db->proccessQuery($query);
        //creates array of each row and make an object product to pass it to function display product
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

            $db1 = new productsController;
            $db1->displayProduct($product, 4);
        }
    }
}
