<?php
require_once __DIR__.'/../vendor/autoload.php';

use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use \Guzzle\Http\Client;

$user = new User('username');
$user->setPhone('79120000000');

$demoProject = new Project(
    '4783', //demo project id
    'key'   //demo project secret key
);

$apiFactory = new ApiFactory($demoProject);

$mobilePaymentApi = $apiFactory->getMobilePaymentApi();

// Calculate the cost of 1000 units of virtual currency
$invoice = $mobilePaymentApi->calculateAmount($user, 1000);
echo 'Cost of 1000 units: ' . $invoice->getAmount() . PHP_EOL;

// Calculate the amount of virtual currency that can be bought for 100 rubles
$invoice = $mobilePaymentApi->calculateVirtualCurrencyAmount($user, 100);
echo 'Amount of virtual currency for 100 rubles: ' . $invoice->getVirtualCurrencyAmount() . PHP_EOL;

// Issue an invoice for a virtual currency for 100 rubles
$invoice = $mobilePaymentApi->createInvoice($user, new Invoice(null, 100));
echo 'Your invoice number: ' . $invoice->getId() . PHP_EOL;
