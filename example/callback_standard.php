<?php

use Symfony\Component\HttpFoundation\Request;
use Xsolla\SDK\Protocol\Command\Factory as CommandFactory;
use Xsolla\SDK\Protocol\Standard;
use Xsolla\SDK\Response\Xml;
use Xsolla\SDK\Security;
use Xsolla\SDK\Storage\Payments;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\Storage\Users;

include '../vendor/autoload.php';

$request = Request::createFromGlobals();

$protocol = new Standard(new Security(), new CommandFactory(), new Project(), new Users(), new Payments());

$response = (new Xml())->get($protocol->getResponse($request));
$response->send();
