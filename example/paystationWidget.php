<?php
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;

include '../vendor/autoload.php';

$user = new User('username',null,null,'email@xsolla.com');

//Link on paystation
$paystation = new \Xsolla\SDK\Widget\Paystation(new Project());
echo $paystation->getLink($user, new Invoice(), [])."\r\n";

//Link on paystation widget with theme "115"
$paydesk = new \Xsolla\SDK\Widget\Paydesk(new Project());
echo $paydesk->getLink($user, new Invoice(), ['theme' => 115])."\r\n";

//Link on directpayment with payment system "26"
$directpayment = new \Xsolla\SDK\Widget\Directpayment(new Project());
echo $directpayment->getLink($user, new Invoice(), ['pid' => 26])."\r\n";

//Link on credit cards widget
$creditCards = new \Xsolla\SDK\Widget\CreditCards(new Project());
echo $creditCards->getLink($user, new Invoice(), [] )."\r\n";

//Link on mobile payment widget
$mobilePayment = new \Xsolla\SDK\Widget\MobilePayment(new Project());
echo $mobilePayment->getLink($user, new Invoice(), [] )."\r\n";


