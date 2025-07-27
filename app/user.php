<?php

    require_once './app/database.php';

    class User {

        private $conn;
        
        // connect to db when a User object is created
        public function __construct() {
            $this->conn = new Database()->connect();
        }

        // add a user
        public function createUser($username, $password) { 
            try {
                $stmt = $this->conn->prepare("INSERT INTO users (username, password)
                VALUES (:username, :password)");
                $stmt->execute([
                    ':username' => $username,
                    ':password' => $password
            ]); 
                echo "New records created successfully";
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get all users
        public function getAllUsers() {
            try {
                $stmt = $this->conn->prepare("SELECT id, username, password FROM users");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get single user by id 
        public function getUserById($id) {
            try {
                $stmt = $this->conn->prepare("SELECT id, username, password FROM users WHERE id=:id");
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
        public function getUserByName($username) {
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
        public function updateUser($id, $username, $password) {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET username=:username, password=:password WHERE id=:id");
                $stmt->execute([
                    ':id' => $id,
                    ':username' => $username,
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
        public function deleteUser($id) {
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

