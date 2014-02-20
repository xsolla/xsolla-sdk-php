<?php
require_once __DIR__.'/../vendor/autoload.php';

use Xsolla\SDK\Api\ApiFactory;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Project;
use Xsolla\SDK\Api\SubscriptionsApi;
use Xsolla\SDK\User;

$demoProject = new Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$apiFactory = new ApiFactory($demoProject);
$subscriptionApi = $apiFactory->getSubscriptionsApi();

$user = new User('v1', 'v2');
$userSubscriptions = $subscriptionApi->search($user, SubscriptionsApi::TYPE_CARD);

if (!isset($userSubscriptions[0])) {
    echo 'Subscriptions not found'.PHP_EOL;
    exit;
}
$invoice = new Invoice(100);
$subscriptionApi->pay($userSubscriptions[0], $invoice);

$subscriptionApi->delete($userSubscriptions[0]);
