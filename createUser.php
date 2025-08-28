<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    header('Content-Type: application/json; charset=utf-8');

    // handle POST request 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {

           
            // Get username and password from POST
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // USERNAME
            // Check if username and password fields are empty
            if (empty($username) || empty($password)) {
                http_response_code(400);
                echo json_encode(["error" => "Username and Password are required!"]);
                exit;
            }
            
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
            // Check if password is less 32 characters
            if (strlen($password) > 32) {
                http_response_code(400);
                echo json_encode(["error" => "Password must should be less than 32 characters"]);
                exit;
            }
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);


            // IMAGE UPLOAD
            // if a photo is UPLOADED
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileName = $_FILES['photo']['name'];
                $fileSize = $_FILES['photo']['size'];
                $fileType = $_FILES['photo']['type'];

                // Check file extension
                $allowedExtension = 'webp';
                // Generate unique filename 
                // get and sanitize extension
                $ext = pathinfo($fileName, PATHINFO_EXTENSION); // get file extension from file (e.g: jpg)
                $ext = strtolower(preg_replace('/[^a-z0-9]+/i', '', $ext)); // only letters/numbers
                $fileName = bin2hex(random_bytes(8)) . "." . $ext; // random name for image (lowercased)

                if ($ext !== $allowedExtension) {
                    http_response_code(400);
                    echo json_encode(["error" => "Only .webp files are allowed!"]);
                    exit;
                }

                // Check MIME type using finfo (safer than $_FILES['type'])
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $fileTmpPath);
                finfo_close($finfo);

                if ($mimeType !== 'image/webp') {
                    http_response_code(400);
                    echo json_encode(["error" => "File is not a valid WebP image!"]);
                    exit;
                }

                // Optional: Check file size (example: max 500kb)
                if ($fileSize > 500 * 1024) {
                    http_response_code(400);
                    echo json_encode(["error" => "File too large. Max 500kb allowed!"]);
                    exit;
                }

                // Create uploads directory if not exists
                // $uploadDir = __DIR__ . "/uploads/";
                // if (!is_dir($uploadDir)) {
                //     mkdir($uploadDir, 0777, true);
                // }

                // Move file to uploads/ folder
                $uploadDir = __DIR__ . "/uploads/";

                // ensure uploadDir ends with separator
                $uploadDir = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR;
                $filePath = $uploadDir . $fileName; // final filesystem path


                // verify uploaded file and move it
                if (!is_uploaded_file($fileTmpPath) && !move_uploaded_file($fileTmpPath, $filePath)) {
                    http_response_code(400);
                    echo json_encode(["error" => "Error moving uploaded file!"]);
                    exit;
                }

            } else {
                http_response_code(400);
                echo json_encode(["error" => "No photo uploaded or upload error!"]);
                exit;
            }

            // Generate file URL
            $fileUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $fileName;


            // Insert NEW user into DB 
            $result = new User()->createUser($username, $fileUrl, $password_hash);
            
            if($result) echo json_encode(["success" => true, "message" => "Added new user!"]);

        } catch (PDOException $e) {

            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        
        }
    }
?>