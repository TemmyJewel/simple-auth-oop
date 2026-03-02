<?php 

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();

use GuzzleHttp\Client;
use App\config\Database;
use App\models\User;
use App\services\AuthService;
use App\Controllers\AuthController;

use App\api\NewsApi;
use App\controllers\NewsController;
use App\services\NewsService;
use App\views\NewsHelper;
use App\services\FileCache;


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

$fileCache = new FileCache();
$newsApi = new NewsApi($client);
$newsService = new NewsService($newsApi, $fileCache);
$newsController = new NewsController($newsService);

