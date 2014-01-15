<?php

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Widget\Paystation;

include '../vendor/autoload.php';

$user = new User('v1');
$invoice = new Invoice(100);

$paystationWidget = new Paystation(new Project());
echo $paystationWidget->getLink($user, $invoice, 'en');