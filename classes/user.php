<?php

    require_once __DIR__ . '/../config/database.php';

    class User {

        private $conn;
        
        // connect to db when a User object is created
        public function __construct() {
            $this->conn = new Database()->connect();
        }

        // add a user
        public function createUser(string $username, string $photo, string $password) : void { 
            try {
                $stmt = $this->conn->prepare("INSERT INTO users (username, photo, password)
                VALUES (:username, :photo, :password)");
                $stmt->execute([
                    ':username' => $username,
                    ':photo' => $photo,
                    ':password' => $password
            ]); 
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get all users
        public function getAllUsers() : array|false {
            try {
                $stmt = $this->conn->prepare("SELECT id, photo, username, password FROM users");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get single user by id 
        public function getUserById(int $id) : array|false {
            try {
                $stmt = $this->conn->prepare("SELECT id, username,photo, password FROM users WHERE id=:id");
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get single user by username 
        public function getUserByName(string $username) : array|false {
            try {
                $stmt = $this->conn->prepare("SELECT id, username, password FROM users WHERE username=:username");
                $stmt->execute([':username' => $username]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // update user
        public function updateUser(int $id, string $username, string $photo, string $password) : int {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET username=:username, photo=:photo, password=:password WHERE id=:id");
                $stmt->execute([
                    ':id' => $id,
                    ':username' => $username,
                    ':photo' => $photo,
                    ':password' => $password
                ]);
                return $stmt->rowCount();
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // delete user 
        public function deleteUser(int $id) : void {
            try {
                $stmt = $this->conn->prepare("DELETE FROM users WHERE id=:id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

    }
?>

