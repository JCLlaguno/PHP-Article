<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    header('Content-Type: application/json; charset=utf-8');

    // handle POST request 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {

            // USERNAME
            // Get username from POST
            $username = trim($_POST['username']);
            // Validate username
            if (empty($username)) {
                http_response_code(400);
                echo json_encode(["error" => "Username required"]);
                exit;
            }
            // 
            if (!preg_match('/^[A-Za-z][A-Za-z0-9_]{3,15}$/', $username)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Username must start with a letter and be 4–16 characters"
                ]);
                exit;
            }
            // Check if username already exists
            $userExist = new User()->getUserByName($username);
            if($userExist) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Username already exists!"
                ]);
                exit;
            }

            // PASSWORD
            // Get password from POST
            $password = trim($_POST['password']);
            if (empty($password)) {
                http_response_code(400);
                echo json_encode(["error" => "Password is required!"]);
                exit;
            }

            // Check if password is less 32 characters
            if (strlen($password) > 32) {
                http_response_code(400);
                echo json_encode(["error" => "Password must should be less than 32 characters"]);
                exit;
            }
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);


            // IMAGE UPLOAD
            // Check if file was uploaded
            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                http_response_code(400);
                echo json_encode(["error" => "No file uploaded"]);
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
                echo json_encode(["error" => "Failed to save file"]);
                exit;
            }

            // Generate file URL
            $fileUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $filename;


            // Insert NEW user into DB 
            $result = new User()->createUser($username, $fileUrl, $password_hash);
            
            if($result) echo json_encode(["success" => true, "message" => "Added new user!"]);

        } catch (PDOException $e) {

            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        
        }
    }
?>