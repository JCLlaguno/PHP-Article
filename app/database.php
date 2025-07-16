 <?php

class Database {

  private $servername;
  private $username;
  private $password;
  private $dbname;
  private $connection;

  
    public function connect() {

      $this->servername = 'localhost';
      $this->username = 'jc';
      $this->password = 'password';
      $this->dbname = 'article';

      try {
        $this->connection = new PDO(
          "mysql:host=$this->servername;dbname=$this->dbname",
           $this->username, 
           $this->password
          );
        // set the PDO error mode to exception
        return $this->connection;
        return $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
          echo "Database error: " . $e->getMessage();
      } catch (Error $e) {
          echo "General error: " . $e->getMessage();
      }
    }
}
?> 