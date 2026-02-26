<?php

namespace App\models;

use PDO;
use App\config\Database;

class User
{
    private $db;

    // Constructor to inject database connection
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    // Register a new user
    function register($username, $email, $password)
    {
        $data = [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];

        $result = $this->db->insert('users', $data);

        if (!$result) {
            return "Registration failed. Please try again.";
        }

        return $result;
    }

    //Check if User Exists
    function findUser($email = null, $username = null)
    {
        if (!$email && !$username) {
            return false;
        }

        // filter out null values
        $data = array_filter([
            'email' => $email,
            'username' => $username
        ]);

        $result = $this->db->selectOne('users', $data);
        
        return $result ? $result : false;
    }


    // Login user
    function login($username, $password)
    {
        $user = $this->findUser(null, $username);
        if (!$user) {
            return false;
        }

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // save token for password reset
    function saveToken($token, $email)
    {
        $expiry = date("Y-m-d H:i:s", time() + 3600);

        $data = [
            'reset_token_hash' => $token,
            'reset_token_expires_at' => $expiry
        ];

        $result = $this->db->update('users', $data, ['email' => $email]);
        return $result;
    }

    // find user by reset token
    function findUserByToken($hashed_token)
    {
        $data = [
            'reset_token_hash' => $hashed_token
        ];

        $result = $this->db->selectOne('users', $data);
        return $result ? $result : false;
    }

    // update password
    function updatePassword($email, $hashedPassword)
    {
        $data = [
            'password' => $hashedPassword,
            'reset_token_hash' => null,
            'reset_token_expires_at' => null
        ];

        $result = $this->db->update('users', $data, ['email' => $email]);
        return $result;
    }
}
