<?php
session_start();

require_once __DIR__ . '/../bootstrap.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $authController->register($_POST);

    if ($result === true) {
        $_SESSION['message'] = "Registration successful!";
        header("Location: login.php?message=registration_success");
        exit;
    }
    if ($result !== true) {
        $_SESSION['message'] = $result;
        header("Location: register.php");
        exit;
    }
}
?>