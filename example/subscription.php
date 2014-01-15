<?php

use Xsolla\SDK\Invoice;
use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User\Subscription;
use Xsolla\SDK\User;

include '../vendor/autoload.php';

$user = new User('v1', 'v2');
$subscription = new Subscription(new Project());

/**
 * Поиск подписок
 */
$userSubscriptions = $subscription->search($user, Subscription::TYPE_CARD);


/**
 * Платеж на 100 голдов с сохраненной карты
 */
$invoice = new Invoice(100);
$subscription->pay($userSubscriptions[0]['subscription_id'], $invoice, Subscription::TYPE_CARD);


/**
 * Удалить карту
 */
$subscription->delete($userSubscriptions[0]['subscription_id'], Subscription::TYPE_CARD);