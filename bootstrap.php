<?php 

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();

use GuzzleHttp\Client;
use App\Config\Database;
use App\Models\User;
use App\Services\AuthService;
use App\Controllers\AuthController;

use App\api\NewsApi;
use App\controllers\NewsController;
use App\Services\NewsService;
use App\views\NewsHelper;

$db = (new Database());
$user = new User($db);
$authService = new AuthService($user);
$authController = new AuthController($authService);
$newsHelper = new NewsHelper();

$client = new Client([
        'base_uri' => 'https://real-time-news-data.p.rapidapi.com/',
        'timeout'  => 10.0,
        'headers' => [
            'x-rapidapi-host' => 'real-time-news-data.p.rapidapi.com',
            'x-rapidapi-key' => $_ENV['RAPID_API_KEY'],
            'Accept' => 'application/json'
	    ]
    ]);

$newsApi = new NewsApi($client);
$newsService = new NewsService($newsApi);
$newsController = new NewsController($newsService);

