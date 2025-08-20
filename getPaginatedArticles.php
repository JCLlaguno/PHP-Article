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
    // get current page (default = 1)
    $page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    // max records to show per page (default = 8)
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 8;
    // how many rows to skip before displaying records.
    $offset = ($page - 1) * $limit;

    // get logged in userid
    $userid = $_SESSION['userid'];

    // set status (3 = display all articles)
    $status  = isset($_GET['status']) ? intval($_GET['status']) : 0;

    // build SQL condition
    $whereClause = "WHERE status = $status AND userid = $userid";
    if ($status === 2) $whereClause = "WHERE userid = $userid";
    
    // get total count of articles
    $totalCount = new Article()->countTotalArticles($whereClause);
    // get total pages for pagination (min = 1 page);
    $totalPages = max(1, ceil($totalCount / $limit));

    // get paginated articles
    $data = new Article()->paginateArticles($limit, $offset, $whereClause); // []

    // convert to JSON {}
    echo json_encode([
        "page" => $page,
        "limit" => $limit,
        "totalCount" => $totalCount,
        "totalPages" => $totalPages,
        "data" => $data
    ]); // returns {} 
?>  