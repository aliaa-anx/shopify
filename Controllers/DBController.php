<?php
class DBController
{
  private $dbHost;
  private $dbUser;
  private $dbPassword;
  private $dbName;
  private $connection;

  public function __construct()
    {
      $this->dbHost = "localhost";
      $this->dbUser = "root";
      $this->dbPassword = "";
      $this->dbName = "securityDB";
    }

  public function openConnection(){
    $this->connection = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);
    if($this->connection->connect_error)
    {
      echo "connection error";
      return false;
    }
    else
    {
      return true;
    }
  }

  public function getConnection() {
    return $this->connection;
}

  public function closeConnection()
  {
    if($this->connection)
    {
      $this->connection->close();
    }
    else
    {
      echo "connection is already closed";
    }
  }

  public function proccessQuery($query)
  {
    $result= mysqli_query($this->connection, $query);
    if($result)
    {
      return $result;
    }
  }
}
?>