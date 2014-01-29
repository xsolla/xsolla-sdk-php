<?php
use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;

require_once __DIR__ . '/../vendor/autoload.php';

$user = new User('username');
$user->setEmail('example@example.com');

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

//Link on paystation
$paystation = new \Xsolla\SDK\Widget\Paystation($demoProject);
echo $paystation->getLink($user, new Invoice(), array()).PHP_EOL;

//Link on paystation widget with theme "115"
$paydesk = new \Xsolla\SDK\Widget\Paydesk($demoProject);
echo $paydesk->getLink($user, new Invoice(), array('theme' => 115)).PHP_EOL;

//Link on directpayment with payment system "26"
$directpayment = new \Xsolla\SDK\Widget\Directpayment($demoProject);
echo $directpayment->getLink($user, new Invoice(), array('pid' => 26)).PHP_EOL;

//Link on credit cards widget
$creditCards = new \Xsolla\SDK\Widget\CreditCards($demoProject);
echo $creditCards->getLink($user, new Invoice(), array()).PHP_EOL;

//Link on mobile payment widget
$mobilePayment = new \Xsolla\SDK\Widget\MobilePayment($demoProject);
echo $mobilePayment->getLink($user, new Invoice(), array()).PHP_EOL;
