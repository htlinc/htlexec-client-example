<?php

require('vendor/autoload.php');

use Dotenv\Dotenv;
use GuzzleHttp\Client as Guzzle;

// usage message
$usage  = "Usage: \n";
$usage .= "  php main.php get-publisher\n";
$usage .= "  php main.php get-datasets\n";
$usage .= "  php main.php get-data <dataset_id>\n";
$usage .= "  php main.php get-dashboards\n";
$usage .= "  php main.php get-widgets <dashboard_id>\n";
$usage .= "  php main.php get-widget-data <dashboard_id> <widget_id>\n\n\n";

// read environment variables 'OAUTH2_TOKEN' and 'BASE_URI'
$dotenv = new Dotenv(__DIR__, '.env');
$dotenv->overload();
$TOKEN = getenv('OAUTH2_TOKEN');
$BASE_URI = getenv('BASE_URI');

// setup HTTP client
$client = new Guzzle([
    'headers' => [
        'Authorization' => 'Bearer ' . $TOKEN,
        'Accept'        => 'application/json',
    ],
    'verify' => false,
]);

// read type of command from CLI argument
$command = isset($argv[1]) ? $argv[1] : null;

// request data from API
if ($command == 'get-publisher')
{
    $response = $client->request('GET', "$BASE_URI/publishers");
}
else if ($command == 'get-datasets')
{
    $response = $client->request('GET', "$BASE_URI/datasets");
}
else if ($command == 'get-data')
{
    if (count($argv) != 3) {
        throw new \Exception("Missing <dataset_id>\n\n$usage");
    }
    $datasetId = $argv[2];
    $response = $client->request('GET', "$BASE_URI/datasets/$datasetId");
}
else if ($command == 'get-dashboards')
{
    $response = $client->request('GET', "$BASE_URI/dashboards");
}
else if ($command == 'get-widgets')
{
    if (count($argv) != 3) {
        throw new \Exception("Missing <dashboard_id>\n\n$usage");
    }
    $dashboardId = $argv[2];
    $response = $client->request('GET', "$BASE_URI/dashboards/$dashboardId");
}
else if ($command == 'get-widget-data')
{
    if (count($argv) != 4) {
        throw new \Exception("Missing <dashboard_id> or <widget_id>\n\n$usage");
    }
    $dashboardId = $argv[2];
    $widgetId = $argv[3];
    $response = $client->request('GET', "$BASE_URI/dashboards/$dashboardId/widgets/$widgetId");
}
else
{
    throw new \Exception("Unknown command\n\n$usage");
    exit($message);
}

// print JSON result
$data = json_decode((string)$response->getBody(), true);
dump($data);
