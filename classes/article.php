<?php

    require_once __DIR__ . '/../config/database.php';

    class Article {
        
        private $conn;
        private int $status;
        
        // connect to db when an Article object is created
        public function __construct() {
            $this->conn = new Database()->connect();
        }

        // add a user
        public function createArticle(int $userid, string $article_title, string $article_content) : void { 
            try {
                $this->status = 0; // unread
                $stmt = $this->conn->prepare("INSERT INTO articles (userid, status, article_title, article_content)
                VALUES (:userid, :status, :article_title, :article_content)");
                $stmt->execute([
                    ':userid' => $userid,
                    ':status' => $this->status,
                    ':article_title' => $article_title,
                    ':article_content' => $article_content
                ]); 
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get all articles
        public function getAllArticles() : array|false {
            try {
                $stmt = $this->conn->prepare("SELECT id, userid, article_title, article_content FROM articles");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }
        
        // paginate articles
        public function paginateArticles(int $limit, int $offset, int $userid) : array|false {
            try {
                $stmt = $this->conn->prepare("SELECT id, userid, article_title, article_content FROM articles WHERE userid = $userid ORDER BY id DESC LIMIT $offset, $limit"); 
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // count all articles
        public function countTotalArticles(int $userid) : int {
            try {
                $stmt = $this->conn->prepare("SELECT COUNT(*) FROM `articles` WHERE userid = $userid");
                $stmt->execute();
                return $stmt->fetchColumn();
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get single article by id 
        public function getArticleById(int $id) :array|false {
            try {
                $stmt = $this->conn->prepare("SELECT id, article_title, article_content FROM articles WHERE id=:id");
                $stmt->execute([':id' => $id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // update article
        public function updateArticle(int $id, string $article_title, string $article_content) : int {
            try {
                $stmt = $this->conn->prepare("UPDATE articles SET article_title=:article_title, article_content=:article_content WHERE id=:id");
                $stmt->execute([
                    ':id' => $id,
                    ':article_title' => $article_title,
                    ':article_content' => $article_content
                ]);
                return $stmt->rowCount();
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // delete article 
        public function deleteArticle(int $id) : void {
            try {
                $stmt = $this->conn->prepare("DELETE FROM articles WHERE id=:id");
                $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }
    }
?>