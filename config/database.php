<?php

    class Database {

      private string $servername;
      private string $username;
      private string $password;
      private string $dbname;
      private $connection;

      
      public function connect() : ?PDO {

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
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $this->connection;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Error $e) {
            echo "General error: " . $e->getMessage();
        }
      }
    }
?> 