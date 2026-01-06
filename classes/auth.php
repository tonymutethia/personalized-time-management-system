<?php
class RegisterController {

    public $fullname;
    public $username;
    public $email;
    public $password;

    public $role;
    public function handleRegistration($data) {
        
        require_once 'includes/db.php';
        $db = new Database();
        $conn = $db->connect();

        $fullname = $conn->real_escape_string(trim($data['fullname']));
        $username = $conn->real_escape_string(trim($data['username']));
        $email = $conn->real_escape_string(trim($data['email']));
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $conn->real_escape_string(trim($data['role']));

        // Check if email already exists
        $checkQuery = "SELECT id FROM users WHERE email = '$email'";
        $checkResult = $conn->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            return "Email already registered.";
        }   

        //check if username exist
          $checkQuery = "SELECT id FROM users WHERE username = '$username'";
        $checkResult = $conn->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            return "username already registered.";
        }   


        // Insert new user
        $insertQuery = "INSERT INTO users (fullname, username, email, password, role) 
                        VALUES ('$fullname', '$username', '$email', '$password', '$role')";

        if ($conn->query($insertQuery)) {
            return "Registration successfully!";
        } else {
            return "Error: " . $conn->error;
        }
    }
    
}


class LoginController {
    public function handleLogin($data) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once 'includes/db.php';
        $db = new Database();
        $conn = $db->connect();

        if (!isset($data['email'], $data['password'])) {
            return "Email and password are required.";
        }

        $email = $conn->real_escape_string(trim($data['email']));
        $password = trim($data['password']);

        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = $conn->query($query);

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Login successful – store session
                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['profile_picture'] = $user['profile_picture'];

                return "Login successful.";
            } else {
                return "Incorrect password.";
            }
        } else {
            return "No user found with that email.";
        }
        
    }
}