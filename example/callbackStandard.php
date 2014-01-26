<?php

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Command\Factory as CommandFactory;
use Xsolla\SDK\Protocol\Standard;
use Xsolla\SDK\Response\Xml;
use Xsolla\SDK\Validator\IpChecker;
use Xsolla\SDK\Storage\PaymentsStandard;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\Storage\Users;

require_once __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();

$protocol = new Standard(new IpChecker(), new CommandFactory(), new Project(), new Users(), new PaymentsStandard());

$xmlResponse = new Xml();
$response = $xmlResponse->get($protocol->getResponse($request));
$response->send();
