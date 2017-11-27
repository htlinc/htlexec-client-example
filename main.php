<?php

require('vendor/autoload.php');

use Dotenv\Dotenv;
use GuzzleHttp\Client as Guzzle;

$command = isset($argv[1]) ? $argv[1] : null;
$publisherSlug = isset($argv[2]) ? $argv[2] : null;
$datasetId = isset($argv[3]) ? $argv[3] : null;

switch ($command) {
    case 'get-publishers':
        $uri = 'publishers';
        break;

    case 'get-datasets' :
        if (!$publisherSlug) {
            dump('Please include a publisher slug');
            exit();
        }
        $uri = "publishers/$publisherSlug/datasets";
        break;

    case 'get-data' :
        if (!$publisherSlug || !$datasetId) {
            dump('Please include a publisher slug and dataset id');
            exit();
        }
        $uri = "publishers/$publisherSlug/datasets/$datasetId";
        break;

    default:
        dump('Not a valid command');
        exit();
        break;
}

$dotenv = new Dotenv(__DIR__, '.env');
$dotenv->overload();

$token = getenv('OAUTH2_TOKEN');

$client = new Guzzle(['base_uri' => 'http://htlexec.dev/api/']);

$headers = [
    'Authorization' => 'Bearer ' . $token,
    'Accept'        => 'application/json',
];

$response = $client->request('GET', $uri, [
    'headers' => $headers
]);

$data = json_decode((string)$response->getBody(), true);
dump($data);
exit();