<?php

class User {
    private $conn;

    // Constructor to inject database connection
    public function __construct(PDO $conn){
        $this->conn = $conn;
    }

    // Register a new user
    function register($username, $email, $password){
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        $result = $stmt->execute([$username, $email, $password]);

        if (!$result){
            error_log("User registration failed: " . implode(", ", $stmt->errorInfo()));
            return "Registration failed. Please try again.";
        }

        return $result;
    }

    //Check if User Exists
    function findUser($email = null, $username = null){
        if ($email) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
        } elseif ($username) {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
        } else {
            return false; // No email or username provided
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? true : false;
    }

    // Login user
    function login($username, $password){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // save token for password reset
    public function saveToken($token, $email) {
        $expiry = date("Y-m-d H:i:s", time() + 3600); 
        $stmt = $this->conn->prepare("UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?");
        return $stmt->execute([$token, $expiry, $email]);
    } 

    // find user by reset token
    public function findUserByToken($hashed_token) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE reset_token_hash = ? ");
        $stmt->execute([$hashed_token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update password
    public function updatePassword($email,  $hashedPassword) {
        $stmt = $this->conn->prepare("UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE email = ?");
        return $stmt->execute([$hashedPassword, $email]);
    }
}
