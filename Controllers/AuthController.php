<?php
require_once 'DBController.php';
require_once 'securityController/cryptoHelper.php';
require_once 'securityController/vendor/autoload.php';
require_once 'securityController/config.php';

use \Firebase\JWT\JWT;

class AuthController
{

  private $jwtSecret = JWTSECRETKEY;
    private $jwtExpiryShort = 60; // 1 minute for access token
    private $refreshExpiry = 120; // 7 days for refresh session
  //Validation/Filtration for the data entered by the user
  public function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  private function generateJWT($payload)
    {
        $payload['exp'] = time() + $this->jwtExpiryShort;  // set expiration time
        return JWT::encode($payload, $this->jwtSecret, 'HS256'); //
    }
  public function login(User $user)
  {
    $name = $this->validate($user->name);
    $password = $this->validate($user->password);
    //checks if there is an empty fleid
    if (empty($name)) {
      header("Location: login.php?error=Username is required");
      exit();
    } elseif (empty($password)) {
      header("Location: login.php?error=Password is required");
      exit();
    } else {
      $db = new DBController;
      $db->openConnection();
      $query = "SELECT * FROM `user` WHERE `name`='$name'";
      $result = $db->proccessQuery($query);
      $row = mysqli_fetch_assoc($result); //makes an array to access its elements easily
      $email = $row['email'];
      $query2 = "SELECT * FROM `iv` WHERE userEmail = '$email'";
      $result2 = $db->proccessQuery($query2);
      $row2 = mysqli_fetch_assoc($result2);
      $iv = $row2['iv'];
      $crypto = new CryptoHelper();
      $decryptedPassword = $crypto->decrypt($row['password'], $iv);
      if ($row['name'] === $name && password_verify($password, $decryptedPassword)) {
        // Generate session token (refresh token)
        $sessionToken = bin2hex(random_bytes(32));
        $sessionExpiry = date('Y-m-d H:i:s', time() + $this->refreshExpiry);
        $escapedToken = $sessionToken;
        $escapedId = (int)$row['id'];

        // Store session in database
        $updateQuery = "UPDATE `user` SET `session_token` = '$escapedToken', 
        `session_expiry` = '$sessionExpiry', 
        `last_activity` = NOW() 
        WHERE `id` = $escapedId";
        $db->proccessQuery($updateQuery);

        // Generate JWT
        $jwt = $this->generateJWT([
          'id' => $row['id'],
          'name' => $row['name'],
          'role' => $row['role'],
          'session_id' => $sessionToken
      ]);
      // Set secure cookies
      setcookie('access_token', $jwt, [
          'expires' => time() + $this->jwtExpiryShort,
          'path' => '/',
          'httponly' => true,
          'secure' => true,
          'samesite' => 'Strict'
      ]);
      
      setcookie('session_token', $sessionToken, [
          'expires' => time() + $this->refreshExpiry,
          'path' => '/',
          'httponly' => true,
          'secure' => true,
          'samesite' => 'Strict'
      ]);
      
      // Redirect based on role
      header("Location: ../../Views/" . $row['role'] . "/index.php");
      exit();

      } else {
        header("Location: login.php?error=Incorrect Username Or Password");
        exit();
      }
    }
  }

  public function logout()
  {
    //I check if session token cookie exist or not, if exist set null
    if (isset($_COOKIE['session_token'])) {
      $db = new DBController();
      if ($db->openConnection()) {
          $escapedToken = $_COOKIE['session_token'];
          $query = "UPDATE user SET session_token=NULL, session_expiry=NULL WHERE session_token='$escapedToken'";
          $db->proccessQuery($query);
      }
  }
  
  // Clear cookies
  setcookie('access_token', '', time() - 3600, '/');
  setcookie('session_token', '', time() - 3600, '/');
  
  // Destroy session
  session_start();
  session_unset();
  session_destroy();
  
  header("Location: login.php");
  exit();
  }

  public function register(User $user)
  {
    //storing values entered by the user into variables
    $name = $this->validate($user->name);
    $email = $this->validate($user->email);
    $password = $this->validate($user->password);
    $number = $this->validate($user->number);

    //Checks if the field is empty
    if (empty($name)) {
      // will send an error by the method 'get' to the url of the register page
      header("Location: register.php?error=Username is required");
      exit();
    } elseif (empty($email)) {
      header("Location: register.php?error=Email is required");
      exit();
    } elseif (empty($password)) {
      header("Location: register.php?error=Password is required");
      exit();
    } elseif (empty($number)) {
      header("Location: register.php?error=Number is required");
      exit();
    } else {
      $db = new DBController;
      $db->openConnection();
      $query1 = "SELECT * FROM `user` WHERE email = '$email'";
      $result1 = $db->proccessQuery($query1);
      preg_match_all('/[^a-zA-Z0-9]/', $name, $nameMatches);
      preg_match_all('/[^a-zA-Z0-9]/', $password, $matches);
      if (count($nameMatches[0]) > 0) {
        header("Location: register.php?error=Name Should Not Contain Any Special Characters !");
        exit();
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error=Email Format in Not Correct !");
        exit();
      } else if (mysqli_num_rows($result1) > 0) {
        header("Location: register.php?error=You can't Register with the Same Email !");
        exit();
      } else if (strlen($password) < 10 || count($matches[0]) <= 0) {
        header("Location: register.php?error=Password Should at Least Contain 10 Characters Including Special Characterrs !");
        exit();
      } else if (!ctype_digit($number) || strlen($number) != 11) {
        header("Location: register.php?error=Number Field Should Contain 11 Digits !");
        exit();
      } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $crypto = new CryptoHelper();
        $result = $crypto->encrypt($hashedPassword);
        $encryptedPassword = $result['encryptedData'];
        $iv = $result['iv'];
        $query = "INSERT INTO `user` (`name`, `password`, `email`, `number`)
      VALUES ('$name','$encryptedPassword','$email','$number')";
        $query2 = "INSERT INTO `iv` VALUES ('$email', '$iv')";
        $db->proccessQuery($query);
        $db->proccessQuery($query2);
        $db->closeConnection();
        header("Location: login.php");  //makes it go directly to the login page
      }
    }
  }

  public function refreshToken()
    {
        if (!isset($_COOKIE['session_token'])) {
            return ['success' => false, 'error' => 'No session token'];
        }
        
        $db = new DBController();
        if (!$db->openConnection()) {
            return ['success' => false, 'error' => 'Database error'];
        }
        
        $escapedToken = $_COOKIE['session_token'];
        $query = "SELECT * FROM user WHERE session_token = '$escapedToken' AND session_expiry > NOW()";
        $result = $db->proccessQuery($query);
        
        if (!$result || $result->num_rows === 0) {
            return ['success' => false, 'error' => 'Invalid or expired session'];
        }
        
        $user = $result->fetch_assoc();
        $newJwt = $this->generateJWT([
            'id' => $user['id'],
            'name' => $user['name'],
            'role' => $user['role'],
            'session_id' => $_COOKIE['session_token']
        ]);
        
        // Update last activity
        $escapedId = (int)$user['id'];
        $updateQuery = "UPDATE user SET last_activity=NOW() WHERE id=$escapedId";
        $db->proccessQuery($updateQuery);
        
        return [
            'success' => true,
            'access_token' => $newJwt,
            'expires_in' => $this->jwtExpiryShort
        ];
    }
}
