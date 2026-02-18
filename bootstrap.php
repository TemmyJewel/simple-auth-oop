<?php 

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();

use App\Config\Database;
use App\Models\User;
use App\Services\AuthService;
use App\Controllers\AuthController;

$db = (new Database())->connect();
$user = new User($db);
$authService = new AuthService($user);
$authController = new AuthController($authService);