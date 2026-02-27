<?php
namespace App\controllers;

require_once __DIR__ . '/../bootstrap.php';

use App\enums\NewsCategory;
use App\services\NewsService;

class NewsController{
    private $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    // Fetch news based on category
    public function index(){
        $selectedCategory = $_GET['cat'] ?? 'General';
        $category = NewsCategory::tryFrom($selectedCategory) ?? NewsCategory::General;

        $newsData = $this->newsService->getNews($category);
        

        return [
            'newsData' => $newsData,
            'category' => $category
        ];

    }

}