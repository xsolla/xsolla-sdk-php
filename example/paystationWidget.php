<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\PaymentPage\UrlBuilderFactory;

$user = new User('username');
$user->setEmail('example@example.com')
    ->setPhone('79000000000');

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$invoice = new Invoice;
$invoice->setVirtualCurrencyAmount(10);

$urlBuilderFactory = new UrlBuilderFactory($demoProject);

$url = $urlBuilderFactory->getCreditCards()
    ->setInvoice($invoice)
    ->setUser($user)
    ->unlockParameterForUser('email')
    ->setCountry('US')
    ->setLocale('fr')
    ->setParameter('description', 'Purchase description')
    ->getUrl();

echo $url . PHP_EOL;