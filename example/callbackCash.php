<?php

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Cash;
use Xsolla\SDK\Protocol\Command\Factory as CommandFactory;
use Xsolla\SDK\Response\Xml;
use Xsolla\SDK\Security;
use Xsolla\SDK\Storage\Payments;
use Xsolla\SDK\Storage\PaymentsCash;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\Storage\Users;

require_once __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();

$protocol = new Cash(new Security(), new CommandFactory(), new Project(), new Users(), new PaymentsCash());

$response = (new Xml())->get($protocol->getResponse($request));
$response->send();

