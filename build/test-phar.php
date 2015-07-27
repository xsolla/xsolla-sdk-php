<?php

require __DIR__.'/artifacts/xsolla.phar';

use Xsolla\SDK\Webhook\WebhookServer;
use Xsolla\SDK\API\XsollaClient;

$client = XsollaClient::factory(array(
    'merchant_id' => 'MERCHANT_ID',
    'api_key' => 'API_KEY',
));

$webhookServer = WebhookServer::create(function () {}, 'PROJECT_SECRET_KEY');
