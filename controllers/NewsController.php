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

    public function index(){
        $selectedCategory = $_GET['cat'] ?? 'General';
        $category = NewsCategory::tryFrom($selectedCategory) ?? NewsCategory::General;

        $newsData = $this->getNews($category);

        return [
            'newsData' => $newsData,
            'category' => $category
        ];

    }

    public function getNews($query){
        return $this->newsService->getNews($query);

    }
}