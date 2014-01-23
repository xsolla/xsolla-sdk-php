<?php

use Guzzle\Http\Client;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User\Subscriptions;
use Xsolla\SDK\User;

include __DIR__.'/../vendor/autoload.php';

$user = new User('v1', 'v2');
$subscription = new Subscriptions(new Client('https://api.xsolla.com'), new Project());

/**
 * Поиск подписок
 */
$userSubscriptions = $subscription->search($user, Subscriptions::TYPE_CARD);
/**
 * Платеж на 100 голдов с сохраненной карты
 */
$invoice = new Invoice(100);
$subscription->pay($userSubscriptions[0], $invoice);

/**
 * Удалить карту
 */
$subscription->delete($userSubscriptions[0]['subscription_id'], Subscriptions::TYPE_CARD);
