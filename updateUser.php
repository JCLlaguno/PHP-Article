<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    header('Content-Type: application/json; charset=utf-8');

    // handle UPDATE request
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {

            // find user by ID
            $userId = trim($_POST['update-user-id']);
            $foundUser = new User()->getUserById($userId);


            /* USERNAME */
            $username = trim($_POST['username']);
            if (empty($username)) {
                http_response_code(400);
                echo json_encode(["status" => "error", "message" => "Username required"]);
                exit;
            }
            
            // validate username
            if (!preg_match('/^[A-Za-z][A-Za-z0-9_]{3,15}$/', $username)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Username must start with a letter and be 4–16 characters and no spaces."
                ]);
                exit;
            }


            /* PASSWORD */
            // Get password from POST
            $newPassword = trim($_POST['new-password']);
            
            // if current password is the same as inputted password
            if(!empty($newPassword) && password_verify($newPassword, $foundUser['password'])) { 
                echo json_encode(['status' => 'error', 'updated' => false, 'message' => 'New password is same as current password!']);
                exit;
            }

            // if no inputted new password
            $passwordHash = empty($newPassword) ?
                $foundUser['password'] // use old password from db
                :
                // if inputted new password
                password_hash($newPassword, PASSWORD_DEFAULT); // hash new password


            /* PHOTO UPLOAD */
            // if a photo is UPLOADED
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileName = $_FILES['photo']['name'];
                $fileSize = $_FILES['photo']['size'];
                $fileType = $_FILES['photo']['type'];

                // Check file extension
                $allowedExtension = 'webp';

                // Create uploads directory if not exists
                $uploadDir = __DIR__ . "/uploads/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // set up local upload directory path
                $uploadDir = __DIR__ . "/uploads/";

                // ensure uploadDir ends with separator
                $uploadDir = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR;

                
                // get OLD PHOTO url from db
                $photoUrl = $foundUser['photo']; // complete url from db
                $oldFileName = basename($photoUrl); // extract FILENAME from url
                $oldImg = $uploadDir . $oldFileName; // append db filename to local upload dir
                if(file_exists($oldImg)) unlink($oldImg); // DELETE old photo locally

                // Generate unique filename for NEW photo
                // get and sanitize extension
                $ext = pathinfo($fileName, PATHINFO_EXTENSION); // get FILE EXTENSION from file (e.g: jpg)
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

                // NEW photo URL to be inserted to db
                $fileUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $fileName;

                
                // final filesystem path of new photo
                $filePath = $uploadDir . $fileName; 

                /* storing photo LOCALLY */
                // verify uploaded file and move it
                if (!move_uploaded_file($fileTmpPath, $filePath)) {
                    http_response_code(500);
                    echo json_encode(["error" => "Error moving uploaded file!"]);
                    exit;
                } 

            } else {
                // if NO new photo is uploaded
                $fileUrl = false;
            }

            /* UPDATE USER */
            $result = new User()->updateUser($userId, $username, $fileUrl, $passwordHash);
            
            // display message based on result
            if ($result) {
                echo json_encode(["status" => "success", 'updated' => true, "message" => "Updated user!"]);
            } else {
                // http_response_code(409);
                echo json_encode(['status' => 'success', 'updated' => false, "message" => "Unchanged values!"]);
            }

        } catch (PDOException $e) {

            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            
        }
    }
?>