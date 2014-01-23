<?php

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Widget\Paystation;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('v1');
$invoice = new Invoice(100);

$paystationWidget = new Paystation(new Project());
echo $paystationWidget->getLink($user, $invoice, 'en');
