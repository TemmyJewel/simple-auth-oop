<?php
namespace App\services;

class FileCache {
    private $cacheDir;
    private $ttl;

    public function __construct($cacheDir = __DIR__ . '/../cache', $ttl = 3600)
    {
        $this->cacheDir = $cacheDir;
        $this->ttl = $ttl;

        if(!is_dir($this->cacheDir)){
            mkdir($this->cacheDir, 0755, true);
        }
    }

    private function getFilename($key){
        $key = md5($key->value);
        return $this->cacheDir . '/' . $key . '.cache';
    }

    // Save Key to cache
    function saveKey($key, $data){
        $cacheFile = $this->getFilename($key);

        $cacheData = [
            'data' => $data,
            'timestamp' => time() + $this->ttl
        ];

        file_put_contents($cacheFile, serialize($cacheData));
    }

    //Fetch key from cache
    function getKey($key){
        $cacheFile = $this->getFilename($key);

        // Check if file exists
        if(file_exists($cacheFile)){
            $content = unserialize(file_get_contents($cacheFile));
            $isExpired = $this->isExpired($content, $cacheFile);
            
            return $isExpired ? null : $content['data'];
        }

        return null;
    }

    // Check if cache file is expired
    private function isExpired($content, $cacheFile){
        if($content['timestamp'] < time()){
            unlink($cacheFile);
            return true;
        }
        return false;
    }
}