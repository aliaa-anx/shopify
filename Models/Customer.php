<?php
require_once 'User.php';
require_once '../../Controllers/securityController/cryptoHelper.php';

class Customer extends User
{

  public static function numOfPurchasedProducts($userId)
  {
    $db = new DBController;
    $db->openConnection();
    $query = "SELECT count(*) FROM records WHERE userId = $userId";
    $count = $db->proccessQuery($query);
    $count = mysqli_fetch_array($count);
    $db->closeConnection();
    return $count[0];
  }
  public static function sendFeedback(Customer $customer, $msg)
  {
    require_once 'C:\xampp\htdocs\security-project\Controllers\DBController.php';
    $db = new DBController;
    $db->openConnection();
    $query = "INSERT INTO feedbacks (userId, username, email, `number`, feedback)
    VALUES ('$customer->id','$customer->name','$customer->email','$customer->number','$msg')";
    $db->proccessQuery($query);
    $db->closeConnection();
  }


  public static function updatPassword($userId, $old_pass, $new_pass, $confirm_pass)
  {

    if (empty($old_pass)) {
      header("Location: update_password.php?error=Old Password is required");
      exit();
    } elseif (empty($new_pass)) {
      header("Location: update_password.php?error=New Password is required");
      exit();
    } elseif (empty($confirm_pass)) {
      header("Location: update_password.php?error=Confirmation Password is required");
      exit();
    } else {
      $db = new DBController;
      $db->openConnection();
      $query1 = "SELECT * FROM user WHERE id='$userId'";
      $result1 = $db->proccessQuery($query1);
      $row = mysqli_fetch_assoc($result1);
      $email = $row['email'];
      $query2 = "SELECT * FROM `iv` WHERE userEmail = '$email'";
      $result2 = $db->proccessQuery($query2);
      $row2 = mysqli_fetch_assoc($result2);
      $iv = $row2['iv'];
      $crypto = new CryptoHelper();
      $decryptedPassword = $crypto->decrypt($row['password'], $iv);
      if (password_verify($old_pass, $decryptedPassword)) {
        if ($confirm_pass == $new_pass) {
          preg_match_all('/[^a-zA-Z0-9]/', $confirm_pass, $matches);
          if (strlen($confirm_pass) < 10 || count($matches[0]) <= 0) {
            header("Location: update_password.php?error=Password Should at Least Contain 10 Characters Including Special Characterrs !");
            exit();
          } else {
            $hashedPassword = password_hash($new_pass, PASSWORD_BCRYPT);
            $result = $crypto->encrypt($hashedPassword);
            $encryptedPassword = $result['encryptedData'];
            $iv = $result['iv'];
            $query3 = "UPDATE `user` SET password ='$encryptedPassword'  where id='$userId'";
            $query4 = "UPDATE `iv` SET iv ='$iv'  where userEmail='$email'";
            $db->proccessQuery($query3);
            $db->proccessQuery($query4);
            return " <script> alert('Your password has been updated successfully') </script>";
          }
        } else {
          header("Location: update_password.php?error= The Confirmation Password Is Incorrect");
        }
      } else {
        header("Location: update_password.php?error= The Old Password Is Incorrect");
        exit();
      }
    }
  }

  public static function updateUsername($userId, $old_pass, $newUsername, $confirmNewUsername)
  {

    if (empty($old_pass)) {
      header("Location: update_username.php?error=Old Password is required");
      exit();
    } elseif (empty($newUsername)) {
      header("Location: update_username.php?error=New Password is required");
      exit();
    } elseif (empty($confirmNewUsername)) {
      header("Location: update_username.php?error=Confirmation Password is required");
      exit();
    } else {
      $db = new DBController;
      $db->openConnection();
      $query1 = "SELECT * FROM user WHERE id='$userId'";
      $result1 = $db->proccessQuery($query1);
      $row = mysqli_fetch_assoc($result1);
      $email = $row['email'];
      $query2 = "SELECT * FROM `iv` WHERE userEmail = '$email'";
      $result2 = $db->proccessQuery($query2);
      $row2 = mysqli_fetch_assoc($result2);
      $iv = $row2['iv'];
      $crypto = new CryptoHelper();
      $decryptedPassword = $crypto->decrypt($row['password'], $iv);
      if (password_verify($old_pass, $decryptedPassword)) {
        if ($confirmNewUsername == $newUsername) {
          $query2 = "UPDATE user SET name ='$confirmNewUsername'  where id='$userId'";
          $db->proccessQuery($query2);
          return "
                          <script> alert('Your username has been updated successfully') </script>
                          ";
        } else {
          header("Location: update_username.php?error= The Confirmation Username Is Incorrect");
        }
      } else {
        header("Location: update_username.php?error= The Old Password Is Incorrect");
        exit();
      }
    }
  }
}
