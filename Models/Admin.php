<?php
require_once 'User.php';
require_once 'C:\xampp\htdocs\security-project\Controllers\DBController.php';
class Admin extends User
{
  public $UserId;



  public static function BlockUser($UserId)
  {

    $db = new DBController;
    $db->openConnection();
    $query = "DELETE FROM `user` WHERE `id` = '$UserId'  ";
    $db->proccessQuery($query);
    $db->closeConnection();
  }



  public static function SearchUser($keyword, $filterType)
  {

    $db = new DBController;
    $db->openConnection();
    $query = "SELECT * FROM `user` WHERE $filterType = '$keyword'  ";
    $db->proccessQuery($query);
    $db->closeConnection();
  }
}
