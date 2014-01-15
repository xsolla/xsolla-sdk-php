<?php

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Invoicing\MobilePayment;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User;

include '../vendor/autoload.php';

/**
 * Платеж на 100 рублей
 */
$invoice = new Invoice(null, 100, 'RUB');
$user = new User('username');

$mobile = new MobilePayment(new Project());
echo $mobile->createInvoice($user, $invoice);