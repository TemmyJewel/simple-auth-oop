<?php
require_once __DIR__ . '/bootstrap.php';

try {
    
    $response = $client->get('search', [
	'query' => [
		'query' => 'Health',
		'limit' => 20,
		'time_published' => 'anytime',
		'country' => 'NG',
		'lang' => 'en'
	]
]);

$data = json_decode($response->getBody()->getContents(), true);


echo "<pre>";
print_r($data);
echo "</pre>";

} catch (\Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}