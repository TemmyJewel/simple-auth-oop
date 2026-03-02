<?php
namespace App\api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use App\enums\NewsCategory;
use App\exception\ApiException;

class NewsApi {
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    // Fetch News data based on query
    public function fetchNews(NewsCategory $category){
        try {
            $response = $this->client->get('search', [
                'query' => [
                    'query' => $category->value,
                    'limit' => 20,
                    'time_published' => 'anytime',
                    'country' => 'NG',
                    'lang' => 'en'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['data'] ?? [];

        } catch (GuzzleException $e) {
            throw new ApiException('News Api Failed', 0, $e);
        } 
    }

    
}

