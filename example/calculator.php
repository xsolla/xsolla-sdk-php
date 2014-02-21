<?php
require_once __DIR__.'/../vendor/autoload.php';

use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Project;

$paypalId = 24;

$demoProject = new Project(
    '4783', //demo project id
    'key'   //demo project secret key
);

$apiFactory = new ApiFactory($demoProject);

$calculatorApi = $apiFactory->getCalculatorApi();

$virtualCurrencyAmount = $calculatorApi->calculateVirtualCurrencyAmount($paypalId, 100);
echo 'Calculation of the amount of the game currency on the basis of the amount of payment 100 via Paypal: ' . $virtualCurrencyAmount . PHP_EOL;

$amount = $calculatorApi->calculateAmount($paypalId, 100);
echo 'Calculation of the amount of payment via Paypal on the basis of the amount of game currency 100: ' . $amount . PHP_EOL;
