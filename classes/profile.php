<?php
class ProfileController {
    public function updateProfile($conn, $userId, $data, $files) {
        $fullname = trim($data['fullname']);
        $email = trim($data['email']);
        $password = trim($data['password']);
        
        $profilePicPath = null;

        // Basic validation
        if (empty($fullname) || empty($email)) {
            return "Fullname and email are required.";
        }

        // Handle profile picture upload
        if (isset($files["profilePictureInput"]) && $files["profilePictureInput"]["error"] === UPLOAD_ERR_OK) {
            $originalName = $files["profilePictureInput"]["name"];
            $tmpName = $files["profilePictureInput"]["tmp_name"];
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);

            $rand = rand(100, 2000);
            $newFileName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . $rand . '.' . $ext;

            $uploadDir = 'public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $targetFile = $uploadDir . $newFileName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                $profilePicPath = $targetFile;
            } else {
                return "Failed to upload profile picture.";
            }
        }

        // Create the dynamic SQL
        $sql = "UPDATE users SET fullname = ?, email = ?";
        $types = "ss";
        $params = [$fullname, $email];

        if (!empty($password)) {
            $sql .= ", password = ?";
            $types .= "s";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($profilePicPath) {
            $sql .= ", profile_picture = ?";
            $types .= "s";
            $params[] = $profilePicPath;
        }

        $sql .= " WHERE id = ?";
        $types .= "i";
        $params[] = $userId;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            header("Location: profile.php?status=success");
exit();

            // return "Profile updated successfully!";
        } else {
            return "Something went wrong. Please try again.";
        }
    }
}
