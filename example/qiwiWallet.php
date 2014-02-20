<?php

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Api\QiwiWallet;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;

use \Guzzle\Http\Client;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('username');
$user->setPhone('79120000000');

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$mobile = new QiwiWallet(new Client('https://api.xsolla.com'), $demoProject);

/**
 *  Calculate the cost of 1000 units of virtual currency
 */
$invoice = $mobile->calculate($user, new Invoice(1000, null));
echo "Cost of 1000 units : {$invoice->getAmount()}".PHP_EOL;

/**
 *  Calculate the amount of virtual currency that can be bought for 10 rubles
 */
$invoice = $mobile->calculate($user, new Invoice(null, 100));
echo "Amount of virtual currency for 100 rubles : {$invoice->getVirtualCurrencyAmount()}".PHP_EOL;

/**
 *  Issue an invoice for a virtual currency for 100 rubles
 */
$invoice = $mobile->createInvoice($user, new Invoice(null, 100));
echo "Your invoice number : {$invoice->getId()}".PHP_EOL;
