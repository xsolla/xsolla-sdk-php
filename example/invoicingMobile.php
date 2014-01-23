<?php

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Invoicing\MobilePayment;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User;

use \Guzzle\Http\Client;

include '../vendor/autoload.php';

$user = new User('username');
$user->setPhone('79120000000');

$mobile = new MobilePayment(new Client('https://api.xsolla.com'), new Project());

/**
 *  Calculate the cost of 1000 units of virtual currency
 */

$invoice = $mobile->calculate($user, new Invoice(1000, null));
echo "Cost of 1000 units : " . $invoice->getSum() . "\r\n";

/**
 *  Calculate the amount of virtual currency that can be bought for 10 rubles
 */

$invoice = $mobile->calculate($user, new Invoice(null, 10));
echo "Amount of virtual currency for 10 rubles : " . $invoice->getOut() . "\r\n";

/**
 *  Issue an invoice for a virtual currency for 10 rubles
 */
$invoice = $mobile->createInvoice($user, new Invoice(null, 10));
echo "Your invoice number : " . $invoice->getId() . "\r\n";
