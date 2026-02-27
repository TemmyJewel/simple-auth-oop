<?php
namespace App\api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

use App\enums\NewsCategory;

require_once __DIR__ . '/../bootstrap.php';

class NewsApi {
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchNews(NewsCategory $query){
        try {
            $response = $this->client->get('search', [
                'query' => [
                    'query' => $query->value,
                    'limit' => 20,
                    'time_published' => 'anytime',
                    'country' => 'NG',
                    'lang' => 'en'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['data'];

        } catch (RequestException $e) {
            return null;
            error_log("Request failed: " . $e->getMessage());
        } catch (ConnectException $e) {
            return null;
            error_log("Connection failed: " . $e->getMessage());
        } catch (ClientException $e) {
            return null;
            error_log("Client error: " . $e->getMessage());
        } catch (ServerException $e) {
            return null;
            error_log("Server error: " . $e->getMessage());
        } catch (\Exception $e) {
            return null;
            error_log("Connection failed: " . $e->getMessage());
        }
    }

    
}

