<?php
    session_start();
    if(!isset($_SESSION['userid'])) {
        http_response_code(401);
        echo json_encode(["error" => "User not logged in!"]);
        exit;
    };
    
    require_once __DIR__ . '/classes/article.php';
    header("Content-Type: application/json");
    
    // Pagination parameters
    // get current page (must be of type INT) (default = 1)
    $page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    // max records to show per page (default = 8)
    $limit = isset($_GET['limit']) ? $_GET['limit'] : 8;
    
    // how many rows to skip before displaying records.
    $offset = ($page - 1) * $limit;

    // get logged in userid
    $userid = $_SESSION['userid'];

    // set status (must be of type INT) (2 = display all articles)
    $status  = isset($_GET['status']) ? (int) $_GET['status'] : 0;

    // build SQL condition
    $whereClause = "WHERE status = :status AND userid = :userid";
    $params = [
        ':status' => $status,
        ':userid' => $userid
    ];
    if ($status === 2) {
        $whereClause = "WHERE userid = :userid";
        $params = [':userid' => $userid];
    };
    
    // get total count of articles
    $totalCount = new Article()->countTotalArticles($whereClause, $params);
    // get total pages for pagination (min = 1 page);
    $totalPages = max(1, ceil($totalCount / $limit));

    // get paginated articles
    $data = new Article()->paginateArticles($limit, $offset, $whereClause, $params); // []

    // convert to JSON {}
    echo json_encode([
        "page" => $page,
        "limit" => $limit,
        "totalCount" => $totalCount,
        "totalPages" => $totalPages,
        "data" => $data
    ]); // JSON response (returns {[]})
?>  