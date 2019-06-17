<?php

require('vendor/autoload.php');

use Dotenv\Dotenv;
use GuzzleHttp\Client as Guzzle;

// read environment variables 'OAUTH2_TOKEN' and 'BASE_URI'
$dotenv = new Dotenv(__DIR__, '.env');
$dotenv->overload();
$TOKEN = getenv('OAUTH2_TOKEN');
$BASE_URI = getenv('BASE_URI');

// setup HTTP client
$client = new Guzzle([
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
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
    $datasetId = $argv[2];
    $response = $client->request('GET', "$BASE_URI/datasets/$datasetId");
}
else if ($command == 'get-dashboards')
{
    $dashboardId = $argv[2];
    $response = $client->request('GET', "$BASE_URI/dashboards/$dashboardId");
}
else if ($command == 'get-widgets')
{
    $dashboardId = $argv[2];
    $response = $client->request('GET', "$BASE_URI/dashboards/$dashboardId");
}
else if ($command == 'get-widget-data')
{
    $dashboardId = $argv[2];
    $widgetId = $argv[3];
    $response = $client->request('GET', "$BASE_URI/dashboards/$dashboardId/widgets/$widgetId");
}
else
{
    throw new \Exception("Invalid command");
}

// print JSON result
$data = json_decode((string)$response->getBody(), true);
dump($data);
exit();

//$entityId = isset($argv[2]) ? $argv[2] : null;
//$widgetId = isset($argv[3]) ? $argv[3] : null;
//
//switch ($command) {
//    case 'get-publishers':
//        $uri = 'publishers';
//        break;
//
//    case 'get-datasets' :
//        $uri = "datasets";
//        break;
//
//    case 'get-data' :
//        if (!$entityId) {
//            dump('Please include a dataset id');
//            exit();
//        }
//        $uri = "datasets/$entityId";
//        break;
//
//    case 'get-dashboards' :
//        $uri = "dashboards";
//        break;
//
//    case 'get-widgets' :
//        if (!$entityId) {
//            dump('Please include a dashboard id');
//            exit();
//        }
//        $uri = "dashboards/$entityId";
//        break;
//
//    case 'get-widget-data' :
//        if (!$entityId || !$widgetId) {
//            dump('Please include a dashboard and widget id');
//            exit();
//        }
//        $uri = "dashboards/$entityId/widgets/$widgetId";
//        break;
//
//    default:
//        dump('Not a valid command');
//        exit();
//        break;
//}




//$response = $client->request('GET', $uri, [
//    'headers' => $headers
//]);


