<?php
require_once __DIR__.'/../vendor/autoload.php';

use Guzzle\Http\Client;
use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Project;

$demoProject = new Project(
    '4783', //demo project id
    'key'   //demo project secret key
);

$apiFactory = new ApiFactory(new Client(), $demoProject);

$calculatorApi = $apiFactory->getCalculatorApi();

// Calculation of the amount of the game currency on the basis of the sum of payment 100 via payment system "1"
echo $calculatorApi->calculateVirtualCurrencyAmount(1, 100) . PHP_EOL;

// Calculation of the amount of payment via payment system "1" on the basis of the amount of game currency 100
echo $calculatorApi->calculateAmount(1, 100) . PHP_EOL;
