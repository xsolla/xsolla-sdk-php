<?php

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Widget\Paystation;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('v1');
$invoice = new Invoice(100);

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$paystationWidget = new Paystation($demoProject);
echo $paystationWidget->getLink($user, $invoice, array('local' => 'en'));
