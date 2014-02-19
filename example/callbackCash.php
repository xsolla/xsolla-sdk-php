<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Validator\IpChecker;
use Xsolla\SDK\Protocol\Storage\Pdo\PaymentCashStorage;
use Xsolla\SDK\Project;
use Xsolla\SDK\Protocol\ProtocolBuilder;

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);
$pdo = new \PDO(sprintf('mysql:dbname=%s;host=%s;', 'YOUR_DB_NAME', 'YOUR_DB_HOST'), 'YOUR_DB_USER', 'YOUR_DB_PASSWORD');
$paymentStorage = new PaymentCashStorage($pdo);
$ipChecker = new IpChecker;
$protocolBuilder = new ProtocolBuilder($demoProject, $ipChecker);
$protocol = $protocolBuilder->getCashProtocol($paymentStorage);

$request = Request::createFromGlobals();
$response = $protocol->run($request);
$response->send();
