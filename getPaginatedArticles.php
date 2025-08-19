<?php
    session_start();
    if(!isset($_SESSION['userid'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "User not logged in!"]);
        exit;
    };

    header("Content-Type: application/json");
    require_once __DIR__ . '/classes/article.php';
    
    // Pagination parameters
    $page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 8;
    $offset = ($page - 1) * $limit;

    // get total count of articles
    $totalCount = new Article()->countTotalArticles($_SESSION['userid'])['total_count'];
    // get total pages for pagination
    $totalPages = ceil($totalCount / $limit);
    // get paginated articles
    $data = new Article()->paginateArticles($limit, $offset, $_SESSION['userid']); // []

    // convert to JSON {}
    echo json_encode([
        "page" => $page,
        "limit" => $limit,
        "totalCount" => $totalCount,
        "totalPages" => $totalPages,
        "data" => $data
    ]); // returns {} 
?>  