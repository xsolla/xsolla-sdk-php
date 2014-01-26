<?php

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Cash;
use Xsolla\SDK\Protocol\Command\Factory as CommandFactory;
use Xsolla\SDK\Response\Xml;
use Xsolla\SDK\Validator\IpChecker;
use Xsolla\SDK\Storage\PaymentsCash;
use Xsolla\SDK\Project;
use Xsolla\SDK\Storage\Users;

require_once __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$protocol = new Cash(new IpChecker(), new CommandFactory(), $demoProject, new Users(), new PaymentsCash());

$xmlResponse = new Xml();
$response = $xmlResponse->get($protocol->getResponse($request));
$response->send();
