<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Project;
use Xsolla\SDK\User\Subscriptions;
use Xsolla\SDK\User;

require_once __DIR__.'/../vendor/autoload.php';

$user = new User('v1', 'v2');

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$subscription = new Subscriptions(new Client('https://api.xsolla.com'), $demoProject);

$userSubscriptions = $subscription->search($user, Subscriptions::TYPE_CARD);

$invoice = new Invoice(100);
$subscription->pay($userSubscriptions[0], $invoice);

$subscription->delete($userSubscriptions[0]);
