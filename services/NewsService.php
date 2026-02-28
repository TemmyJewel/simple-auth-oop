<?php
namespace App\services;

require_once __DIR__ . '/../bootstrap.php';

use App\api\NewsApi;
use App\services\FileCache;


class NewsService{
    private $newsApi;
    private $fileCache;

    public function __construct(NewsApi $newsApi, FileCache $fileCache)
    {
        $this->newsApi = $newsApi;
        $this->fileCache = $fileCache;
    }

    // Fetch news 
    public function getNews($category){
        $news_data = $this->fileCache->getKey($category);

        if($news_data === null){
            $news_data = $this->newsApi->fetchNews($category);

            if(!is_array($news_data)){
                return $news_data;
            }

            $news_data = $this->formatNewsData($news_data);
            $this->fileCache->saveKey($category, $news_data);
        }

        return $news_data;
    }

    // Filter and format news data
    private function formatNewsData($news_data){
        return array_map(function($news_item){
            return [
                'title' => $news_item['title'],
                'link' => $news_item['link'],
                'snippet' =>  $news_item['snippet'] ?? 'No description available.',   
                'authors' => $news_item['authors'] ?? []
            ];
        }, $news_data);
    }
}