<?php
namespace App\controllers;

use App\dto\AuthDTO;
use App\services\AuthService;

class AuthController
{
    private $authService;

    // Inject AuthService dependency
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Handle registration request
    public function register($data): bool|string
    {
        $authDto = new AuthDTO(
            $data['username'],
            $data['email'],
            $data['password']
        );

        // Check if all required fields are present
        if (empty($authDto->username) || empty($authDto->email) || empty($authDto->password)) {
            return "All fields are required.";
        }

        // Sanitize and validate input data
        $authDto->username = htmlspecialchars(trim($authDto->username));
        $email = filter_var(trim($authDto->email), FILTER_VALIDATE_EMAIL);

        if (!$email) {
            return "Invalid email format.";
        }

        // Ensure password is at least 8 characters long
        if (strlen($authDto->password) < 8) {
            return "Password must be at least 8 characters long.";
        }

        // Call the AuthService register method
        return $this->authService->register($authDto);
    }

    // Handle login request
    public function login($data)
    {
        $authDto = new AuthDTO(
            username: $data['username'],
            password: $data['password']
        );

        // Check if all required fields are present
        if (empty($authDto->username) || empty($authDto['password'])) {
            return "All fields are required.";
        }

        // Sanitize input data
        $authDto->username = htmlspecialchars(trim($authDto->username));

        // Call the AuthService login method
        return $this->authService->login($authDto);
    }

    // Handle password recovery
    public function recoverPassword($data)
    {
        if (empty($data['email'])) {
            return ['success' => false, 'message' => 'Email is required.'];
        }

        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }

        $token = $this->authService->recoverPassword($email);

        if (!$token) {
            return ['success' => false, 'message' => 'No user found with that email address.'];
        }

        return ['success' => true, 'token' => $token];
    }

    // Handle password reset
    public function resetPassword($data, $hashed_token)
    {
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