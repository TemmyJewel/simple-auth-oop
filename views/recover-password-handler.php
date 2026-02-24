<?php
session_start();

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $result = $authController->recoverPassword($_POST);

    if ($result['success'] === true) {
        $token = $result['token'];
        header("Location: reset-password.php?token=" . urlencode($token));
        exit;
    }

    $_SESSION['message'] = $result['message'];
    header("Location: recover-password.php");

    exit;
}