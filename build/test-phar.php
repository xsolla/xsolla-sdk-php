<?php
require __DIR__ . '/artifacts/xsolla.phar';

use Xsolla\SDK\IPN\IPNServer;
use Xsolla\SDK\API\XsollaClient;

$client = XsollaClient::factory(array(
    'merchant_id' => 'MERCHANT_ID',
    'api_key' => 'API_KEY'
));

$IPNServer = IPNServer::create(function () {}, 'PROJECT_SECRET_KEY');