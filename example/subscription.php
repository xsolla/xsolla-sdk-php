<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Project;
use Xsolla\SDK\Api\Subscriptions;
use Xsolla\SDK\User;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('v1', 'v2');

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$apiFactory = new ApiFactory(new Client(), $demoProject);

$subscriptionApi = $apiFactory->getSubscriptionsApi();

$userSubscriptions = $subscriptionApi->search($user, Subscriptions::TYPE_CARD);

$invoice = new Invoice(100);
$subscriptionApi->pay($userSubscriptions[0], $invoice);

$subscriptionApi->delete($userSubscriptions[0]);
