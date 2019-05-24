<?php

require('vendor/autoload.php');

use Dotenv\Dotenv;
use GuzzleHttp\Client as Guzzle;

$command = isset($argv[1]) ? $argv[1] : null;
$entityId = isset($argv[2]) ? $argv[2] : null;
$widgetId = isset($argv[3]) ? $argv[3] : null;

switch ($command) {
    case 'get-publishers':
        $uri = 'publishers';
        break;

    case 'get-datasets' :
        $uri = "datasets";
        break;

    case 'get-data' :
        if (!$entityId) {
            dump('Please include a dataset id');
            exit();
        }
        $uri = "datasets/$entityId";
        break;

    case 'get-dashboards' :
        $uri = "dashboards";
        break;

    case 'get-widgets' :
        if (!$entityId) {
            dump('Please include a dashboard id');
            exit();
        }
        $uri = "dashboards/$entityId";
        break;

    case 'get-widget-data' :
        if (!$entityId || !$widgetId) {
            dump('Please include a dashboard and widget id');
            exit();
        }
        $uri = "dashboards/$entityId/widgets/$widgetId";
        break;

    default:
        dump('Not a valid command');
        exit();
        break;
}

$dotenv = new Dotenv(__DIR__, '.env');
$dotenv->overload();

$token = getenv('OAUTH2_TOKEN');
$baseUri = getenv('BASE_URI').'oauth/';

$client = new Guzzle(['base_uri' => $baseUri, 'verify' => false]);

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
