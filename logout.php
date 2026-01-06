<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session completely
session_destroy();

// Optional: Redirect with logout message
header("Location: login.php?logged_out=1");
exit;
