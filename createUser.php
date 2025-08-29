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
            
            // validate username
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


            /* PHOTO UPLOAD */
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileSize    = $_FILES['photo']['size'];

                // Generate random name (always .webp since we convert everything)
                $fileName = bin2hex(random_bytes(8)) . ".webp";

                // Detect MIME type
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $fileTmpPath);
                finfo_close($finfo);

                // Load uploaded file into GD directly
                switch ($mimeType) {
                    case 'image/jpeg':
                        $srcImage = imagecreatefromjpeg($fileTmpPath);
                        break;
                    case 'image/png':
                        $srcImage = imagecreatefrompng($fileTmpPath);
                        break;
                    case 'image/webp':
                        $srcImage = function_exists('imagecreatefromwebp')
                            ? imagecreatefromwebp($fileTmpPath)
                            : imagecreatefromstring(file_get_contents($fileTmpPath));
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

                if ($srcImage) {
                    $srcWidth  = imagesx($srcImage);
                    $srcHeight = imagesy($srcImage);

                    // Square crop
                    $minSide = min($srcWidth, $srcHeight);
                    $srcX = (int)(($srcWidth  - $minSide) / 2);
                    $srcY = (int)(($srcHeight - $minSide) / 2);

                    $thumbWidth  = 32;
                    $thumbHeight = 32;
                    $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

                    // Preserve transparency for PNG
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

                    // Save directly as WebP in uploads/
                    $uploadDir = __DIR__ . "/uploads/";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $thumbPath = $uploadDir . $fileName;
                    imagewebp($thumbImage, $thumbPath, 80);

                    // Free memory
                    imagedestroy($srcImage);
                    imagedestroy($thumbImage);
                } else {
                    http_response_code(500);
                    echo json_encode(["error" => "Error creating WebP thumbnail!"]);
                    exit;
                }

            } else {
                http_response_code(400);
                echo json_encode(["error" => "No photo uploaded or upload error!"]);
                exit;
            }

            // Generate file URL to be inserted to db
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