<?php

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Storage\PaymentsStandard;
use Xsolla\SDK\Project;
use Xsolla\SDK\Storage\Users;

require_once __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$usersStorage = new \Xsolla\SDK\Storage\Null\Users();
$paymentsStorage = new \Xsolla\SDK\Storage\Null\PaymentsStandard();

$protocolBuilder = new \Xsolla\SDK\Protocol\ProtocolBuilder($demoProject);

$protocol = $protocolBuilder->getStandardProtocol($usersStorage, $paymentsStorage);

$response = $protocol->run($request);

$response->send();
