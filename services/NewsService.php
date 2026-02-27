<?php
namespace App\services;

class NewsService{
    private $newsApi;

    public function __construct($newsApi)
    {
        $this->newsApi = $newsApi;
    }

    // Fetch news 
    public function getNews($query){
        $news_data = $this->newsApi->fetchNews($query);

        if (!$news_data) {
            return "Failed to fetch news data.";
        }


        $news_data = array_map(function($news_item){
            return [
                'title' => $news_item['title'],
                'link' => $news_item['link'],
                'snippet' =>  $news_item['snippet'] ?? 'No description available.',   
                'authors' => $news_item['authors'] ?? []
            ];
        }, $news_data);


        return $news_data;
    }
}