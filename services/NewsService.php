<?php
namespace App\services;

require_once __DIR__ . '/../bootstrap.php';

use App\api\NewsApi;
use App\exception\ApiException;
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
        $cache = $this->fileCache->getKey($category);

        if($cache !== null && !$cache['is_expired']){
            return $cache['data'];
        }

        // If cache is expired
        try{
                $api_data = $this->newsApi->fetchNews($category);
                $news_data = $this->formatNewsData($api_data);

                $this->fileCache->saveKey($category, $news_data);
                return $news_data;

            }catch(ApiException $e){
                error_log("Api Failed ". $e->getMessage());
                
                if($cache !== null){
                    return $cache['data'];
                }

                return [];
            }
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