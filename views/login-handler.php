<?php
session_start();

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $authController->login($_POST);

    if (is_array($result)) {

        // Save user info in session
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['message'] = "Welcome back, " . $result['username'] . "!";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['message'] = is_string($result) ? $result : "Invalid username or password.";
        header("Location: login.php");
        exit;
    }
}