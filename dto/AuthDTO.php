<?php

namespace App\dto;

class AuthDTO
{
    public function __construct(
        public string $username = '',
        public string $email = '',
        public string $password = '',
    ) {
    }
}