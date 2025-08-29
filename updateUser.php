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
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileSize    = $_FILES['photo']['size'];

                // Generate random .webp filename
                $fileName = bin2hex(random_bytes(8)) . ".webp";

                // Detect MIME type
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $fileTmpPath);
                finfo_close($finfo);

                // Load uploaded image into GD
                switch ($mimeType) {
                    case 'image/jpeg':
                        $srcImage = imagecreatefromjpeg($fileTmpPath);
                        break;
                    case 'image/png':
                        $srcImage = imagecreatefrompng($fileTmpPath);
                        break;
                    case 'image/webp':
                        if (function_exists('imagecreatefromwebp')) {
                            $srcImage = imagecreatefromwebp($fileTmpPath);
                        } else {
                            $srcImage = imagecreatefromstring(file_get_contents($fileTmpPath));
                        }
                        break;
                    default:
                        http_response_code(400);
                        echo json_encode(["error" => "Unsupported image type: $mimeType"]);
                        exit;
                }

                // Validate file size (max 2 MB before conversion)
                if ($fileSize > 2 * 1024 * 1024) { // 2 MB = 2097152 bytes
                    http_response_code(400);
                    echo json_encode(["error" => "File too large. Max 2 MB allowed!"]);
                    exit;
                }

                // Prepare uploads directory
                $uploadDir = __DIR__ . "/uploads/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Delete old photo if exists
                $photoUrl = $foundUser['photo'];
                $oldFileName = basename($photoUrl);
                $oldImg = $uploadDir . $oldFileName;
                if (file_exists($oldImg)) unlink($oldImg);

                // --- 📌 Square crop + resize ---
                $srcWidth  = imagesx($srcImage);
                $srcHeight = imagesy($srcImage);

                // Find smallest side (to crop square)
                $minSide = min($srcWidth, $srcHeight);
                $srcX = (int)(($srcWidth  - $minSide) / 2);
                $srcY = (int)(($srcHeight - $minSide) / 2);

                $thumbWidth  = 32;
                $thumbHeight = 32;
                $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

                // Preserve transparency if PNG
                if ($mimeType === 'image/png') {
                    imagecolortransparent($thumbImage, imagecolorallocatealpha($thumbImage, 0, 0, 0, 127));
                    imagealphablending($thumbImage, false);
                    imagesavealpha($thumbImage, true);
                }

                // Crop + resize in one step
                imagecopyresampled(
                    $thumbImage, $srcImage,
                    0, 0, $srcX, $srcY,
                    $thumbWidth, $thumbHeight,
                    $minSide, $minSide
                );

                // Save final thumbnail directly as WebP
                $filePath = $uploadDir . $fileName;
                if (!imagewebp($thumbImage, $filePath, 80)) {
                    http_response_code(500);
                    echo json_encode(["error" => "Error creating WebP thumbnail!"]);
                    exit;
                }

                // Free memory
                imagedestroy($srcImage);
                imagedestroy($thumbImage);

                // Build file URL to store in DB
                $fileUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $fileName;

            } else {
                // No new photo → keep old photo
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