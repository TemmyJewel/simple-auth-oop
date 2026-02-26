<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_unset();
    session_destroy();


    session_start();
    $_SESSION['message'] = "You have been logged out successfully.";
    header("Location: login.php");
    exit();
} 
