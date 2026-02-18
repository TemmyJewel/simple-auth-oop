<?php 
namespace App\controllers;

use App\services\AuthService;

class AuthController {
    private $authService;

    // Inject AuthService dependency
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Handle registration request
    public function register($data){
        // Check if all required fields are present
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            return "All fields are required.";
        }

        // Sanitize and validate input data
        $username = htmlspecialchars(trim($data['username']));
        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        $password = trim($data['password']);

        if (!$email) {
            return "Invalid email format.";
        }

        // Ensure password is at least 8 characters long
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters long.";
        }

        // Call the AuthService register method
        return $this->authService->register($username, $email, $password);
    }

    // Handle login request
    public function login($data){
        // Check if all required fields are present
        if (empty($data['username']) || empty($data['password'])) {
            return "All fields are required.";
        }

        // Sanitize input data
        $username = htmlspecialchars(trim($data['username']));
        $password = trim($data['password']);

        // Call the AuthService login method
        return $this->authService->login($username, $password);
    }

    // Handle password recovery
    public function recoverPassword($data){
        if (empty($data['email'])) {
            return ['success' => false, 'message' => 'Email is required.'];
        }

        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        $token = $this->authService->recoverPassword($email);

        if(!$token) {
            return ['success' => false, 'message' => 'No user found with that email address.'];
        }

        return ['success' => true, 'token' => $token];
    }

    // Handle password reset
    public function resetPassword($data, $hashed_token){
        if (empty($data['password']) || empty($data['confirm_password'])) {
            return "All fields are required.";
        }

        $password = trim($data['password']);
        $confirmPassword = trim($data['confirm_password']);
    
        if ((strlen($password) < 8) || (strlen($confirmPassword) < 8)) {
            return "Password must be at least 8 characters long.";
        }

        if ($password !== $confirmPassword) {
            return "Passwords do not match.";
        }

        return $this->authService->resetPassword($hashed_token, $password);
    }
}