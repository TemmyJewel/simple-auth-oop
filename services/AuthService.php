<?php
namespace App\services;

use App\dto\AuthDTO;
use App\models\User;

class AuthService
{
    private $user;

    // Inject user model dependency
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // Registration method
    public function register(AuthDTO $data)
    {
        // Check if user already exists
        $userExists = $this->user->findUser($data->email, $data->username);

        if ($userExists) {
            return "User with this email or username already exists.";
        }

        $hashedPassword = password_hash($data->password, PASSWORD_DEFAULT);
        return $this->user->register($data->username, $data->email, $hashedPassword);
    }

    // Login method
    public function login(AuthDTO $data)
    {
        return $this->user->login($data->username, $data->password);
    }

    // Password recovery method
    public function recoverPassword($email)
    {
        $user = $this->user->findUser($email, null);

        if ($user) {
            $token = bin2hex(random_bytes(16));
            $token_hash = hash('sha256', $token);
            $saveToken = $this->user->saveToken($token_hash, $email);

            if (!$saveToken) {
                error_log("Failed to save reset token for email: " . $email);
                return null;
            }

            return $token;
        }

        return null;
    }

    // Reset password method
    public function resetPassword($hashed_token, $newPassword)
    {
        $user = $this->user->findUserByToken($hashed_token);

        if (!$user) {
            return null;
        }

        if ($user['reset_token_expires_at'] < date("Y-m-d H:i:s")) {
            return null;
        }

        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            return $this->user->updatePassword($user['email'], $hashedPassword);
        }

        return false;
    }
}