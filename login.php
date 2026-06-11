<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Hardcoded credentials as requested
    $default_username = "mafikul";
    $default_password = "admin";

    if ($username === $default_username && $password === $default_password) {
        // Create an authorization ticket in the session
        $_SESSION['authenticated'] = true;
        $_SESSION['user'] = $username;
        
        // Redirect directly to the dashboard form
        header("Location: add_form.php");
        exit;
    } else {
        // Save an error message and bounce back to login form
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: login_form.php");
        exit;
    }
} else {
    header("Location: login_form.php");
    exit;
}
?>