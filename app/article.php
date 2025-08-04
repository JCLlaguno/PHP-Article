<?php

    require_once './app/database.php';

    class Article {
        
        private $conn;
        
        // connect to db when an Article object is created
        public function __construct() {
            $this->conn = new Database()->connect();
        }

        // add a user
        public function createArticle($userid, $article_title, $article_content) { 
            try {
                $stmt = $this->conn->prepare("INSERT INTO articles (userid, article_title, article_content)
                VALUES (:userid, :article_title, :article_content)");
                $stmt->execute([
                    ':userid' => $userid,
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
        public function getAllArticles() {
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
        public function paginateArticles($limit, $offset) {
            try {
                $stmt = $this->conn->prepare("SELECT id, userid, article_title, article_content FROM articles ORDER BY id DESC LIMIT $offset, $limit "); // offset, limit
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // count all articles
        public function countTotalArticles() {
            try {
                $stmt = $this->conn->prepare("SELECT COUNT(*) As total_count FROM `articles`");
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Database error:" . $e->getMessage();
            } catch (Error $e) {
                echo "General error: " . $e->getMessage();
            }
        }

        // get single article by id 
        public function getArticleById($id) {
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
        public function updateArticle($id, $article_title, $article_content) {
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
        public function deleteArticle($id) {
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