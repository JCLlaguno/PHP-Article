<?php
    require_once __DIR__ . '/includes/session.php';
    require_once __DIR__ . '/classes/user.php';
    header('Content-Type: application/json; charset=utf-8');

    // handle UPDATE request
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {

           
            // Get username and password (optional) from POST 
            $username = trim($_POST['username']);
            $newPassword = trim($_POST['new-password']);

            // find user by ID
            $userId = trim($_POST['update-user-id']);
            $foundUser = new User()->getUserById($userId);


            // USERNAME
            // VALIDATE USERNAME
            // Check if username and password fields are empty
            if (empty($username)) {
                http_response_code(400);
                echo json_encode(["error" => "Username is required!"]);
                exit;
            }

            // 1. Username must start with a letter
            if (!preg_match('/^[A-Za-z]/', $username)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Username must start with a letter."
                ]);
                exit;
            }

            // 2. Username length must be between 4 and 16 characters
            if (strlen($username) < 4 || strlen($username) > 16) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Username must be 4–16 characters long."
                ]);
                exit;
            }

            // 3. Username must not contain spaces
            if (preg_match('/\s/', $username)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Username must not contain spaces."
                ]);
                exit;
            }


            /* PASSWORD */
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

                // Validate file size (max 2 MB before conversion)
                if ($fileSize > 2 * 1024 * 1024) { // 2 MB = 2097152 bytes
                    http_response_code(400);
                    echo json_encode(["error" => "File too large. Max 2 MB allowed!"]);
                    exit;
                }

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
                $srcX = (int)(($srcWidth  - $minSide) / 2); // x offset
                $srcY = (int)(($srcHeight - $minSide) / 2); // y offset

                $thumbWidth  = 32;
                $thumbHeight = 32;
                $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight); // blank 32 x 32 canvas

                // Preserve transparency for PNG
                if ($mimeType === 'image/png') {
                    imagecolortransparent($thumbImage, imagecolorallocatealpha($thumbImage, 0, 0, 0, 127));
                    imagealphablending($thumbImage, false);
                    imagesavealpha($thumbImage, true);
                }

                // Crop + resize in one step
                // Copy a square region ($minSide × $minSide) from $srcImage (starting at $srcX,$srcY),
                // resize it smoothly, and draw it onto the blank 32×32 thumbnail canvas ($thumbImage)
                imagecopyresampled(
                    $thumbImage, $srcImage,
                    0, 0, $srcX, $srcY,
                    $thumbWidth, $thumbHeight,
                    $minSide, $minSide
                );

                // Save the thumbnail as a WebP image at $thumbPath with 80% quality (balance between size & quality)

                $thumbPath = $uploadDir . $fileName;// Set the file path where the thumbnail will be saved (upload folder + filename)

                if (!imagewebp($thumbImage, $thumbPath, 80)) {
                    http_response_code(500);
                    echo json_encode(["error" => "Error creating WebP thumbnail!"]);
                    exit;
                }

                // Free up memory used by the images (important if processing many files)
                imagedestroy($srcImage);
                imagedestroy($thumbImage);

                // Build file URL to store in DB
                $fileUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $fileName;

            } else {
                // No new photo -> keep old photo
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