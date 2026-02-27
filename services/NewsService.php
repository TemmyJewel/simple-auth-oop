<?php
namespace App\services;

class NewsService{
    private $newsApi;

    public function __construct($newsApi)
    {
        $this->newsApi = $newsApi;
    }

    // Fetch news 
    public function getNews($category){
        $news_data = $this->newsApi->fetchNews($category);

        if (!is_array($news_data)) {
            return $news_data;
        }

        $news_data = $this->formatNewsData($news_data);
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