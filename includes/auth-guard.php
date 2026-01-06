<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in or role doesn't match
function requireRole($role) {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== $role) {
        header("Location: ../login.php");
        exit;
    }
}

function requireLogin(){

    if(!isset($_SESSION['user_id'])){
        header("location: login.php");
    exit;
    }
    

}
