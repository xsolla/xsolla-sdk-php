<?php

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Protocol;
use Xsolla\SDK\Storage\PaymentsCash;
use Xsolla\SDK\Project;

require_once __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$paymentsStorage = new \Xsolla\SDK\Storage\Null\PaymentsCash();

$protocolBuilder = new \Xsolla\SDK\Protocol\ProtocolBuilder($demoProject);

$protocol = $protocolBuilder->getCashProtocol($paymentsStorage);

$response = $protocol->run($request);

$response->send();
