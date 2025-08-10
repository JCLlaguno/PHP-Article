<?php
    session_start();
    require_once './classes/user.php';

    // handle POST request 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json; charset=utf-8');

        try {
            // Get username from POST
            $username = trim($_POST['username']) ?? '';
            if (empty($username)) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Username required"]);
                exit;
            }

            // Get password from POST
            $password = trim($_POST['password']) ?? '';
            if (empty($password)) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Password required"]);
                exit;
            }
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);


            // IMAGE UPLOAD
            // Check if file was uploaded
            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "No file uploaded"]);
                exit;
            }

            // Create uploads directory if not exists
            $uploadDir = __DIR__ . "/uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate unique filename 
            // get and sanitize extension
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION); // get file extension from file (e.g: jpg)
            $ext = strtolower(preg_replace('/[^a-z0-9]+/i', '', $ext)); // only letters/numbers
            $filename = bin2hex(random_bytes(8)) . "." . $ext; // random name for image (lowercased)

            // ensure uploadDir ends with separator
            $uploadDir = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR;
            $filePath = $uploadDir . $filename; // final filesystem path

            // verify uploaded file and move it
            if (!is_uploaded_file($_FILES['photo']['tmp_name']) || !move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                http_response_code(500);
                echo json_encode(["status" => "error", "message" => "Failed to save file"]);
                exit;
            }

            // Generate file URL
            $fileUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $filename;


            // Insert NEW user into DB 
            new User()->createUser($username, $fileUrl, $password_hash);
            echo json_encode(["status" => "success", "message" => "Added new user!", "url" => $fileUrl]);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
    
?>