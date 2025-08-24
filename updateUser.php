<?php
    session_start();
    require_once __DIR__ . '/classes/user.php';

    // handle UPDATE request
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            header('Content-Type: application/json; charset=utf-8');


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
            if(
                isset($_FILES['photo']) 
                && $_FILES['photo']['error'] === UPLOAD_ERR_OK 
                && is_uploaded_file($_FILES['photo']['tmp_name'])) {

                // temp location of uploaded photo
                $tmpLoc = $_FILES['photo']['tmp_name'];

                // set up local upload directory path
                $uploadDir = __DIR__ . "/uploads/";
                
                // get old photo url from db
                $photoUrl = $foundUser['photo']; // complete url from db
                $oldFileName = basename($photoUrl); // extract filename from url
                $oldImg = $uploadDir . $oldFileName; // append db filename to local upload dir
                if(file_exists($oldImg)) unlink($oldImg); // DELETE old photo locally

                // generate filename for NEW photo
                $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION); // get FILE EXTENSION from file (e.g: jpg)
                $filename = bin2hex(random_bytes(8)) . "." . strtolower($extension); // unique file name for NEW image (lowercased)

                // new photo url to be inserted to db
                $fileUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/uploads/" . $filename;

                // storing photo on local server directory, 'updated' => false
                $filePath = $uploadDir . $filename; // final filesystem path of new photo
                // if false, move uploaded photo from tmp location to local server directory
                // if true, throw an error
                if (!is_uploaded_file($tmpLoc) || !move_uploaded_file($tmpLoc, $filePath)) {
                    http_response_code(500);
                    echo json_encode(["status" => "error", "message" => "Failed to save file"]);
                    exit;
                }

            } else {
                /* 
                    if NO new photo is uploaded
                    reuse existing photo from db 
                */
                $fileUrl = $foundUser['photo'];
            }
            /* UPDATE USER */
            $result = new User()->updateUser($userId, $username, $fileUrl, $passwordHash);
            
            // display message based on result
            if ($result) {
                echo json_encode(["status" => "success", 'updated' => true, "message" => "Updated user!"]);
            } else {
                // http_response_code(409);
                echo json_encode(['status' => 'success', 'updated' => false, "message" => "Same values!"]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
?>