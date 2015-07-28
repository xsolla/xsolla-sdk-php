# Xsolla SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/xsolla/xsolla-sdk-php/v/stable.png)](https://packagist.org/packages/xsolla/xsolla-sdk-php)
[![Build Status](https://travis-ci.org/xsolla/xsolla-sdk-php.png?branch=master)](https://travis-ci.org/xsolla/xsolla-sdk-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/quality-score.png?b=v2)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php)
[![Join the chat at https://gitter.im/xsolla/xsolla-sdk-php](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/xsolla/xsolla-sdk-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/xsolla/xsolla-sdk-php/master/LICENSE)

An official PHP SDK for interacting with [Xsolla API](http://developers.xsolla.com)

![Payment UI screenshot](http://xsolla.cachefly.net/img/ps3_github_new.png)

## Features

* Full customisation of Payment UI with the help of different methods of getting token.
* Client for all API methods, making your integration easy and convenient. You can use it for setting up and updating virtual currency, items and subscription plans, for managing the users balance, for checking the finance information with the help of Report API and so on.
* Convenient webhook server:
  * To start you need only one callback function.
  * All security checking already implemented: signature authentication and IP whitelisting.
  * Full customisation of notification processing logic, if standard server class doesn’t suit you.
* SDK is built on Guzzle v3, and utilizes many of its features, including persistent connections, parallel requests, events and plugins (via Symfony2 EventDispatcher), service descriptions, over-the-wire logging, caching, flexible batching, and request retrying with truncated exponential back off.

## Requirements

* PHP 5.3.9+
* Your php.ini needs to have the date.timezone setting
* The following PHP extensions are required:
  * curl
  * json

## Installation

### Installing via Composer

The recommended way to install Xsolla SDK for PHP is through [Composer](http://getcomposer.org).

``` bash
$ cd /path/to/your/project
$ composer require xsolla/xsolla-sdk-php
```

### Installing via Phar

You can [download the packaged phar](https://github.com/xsolla/xsolla-sdk-php/releases) and include it in your scripts to get started:

``` php
require '/path/to/xsolla.phar';
```

### Installing via Zip

You can [download the zip file](https://github.com/xsolla/xsolla-sdk-php/releases), unzip it into your project to a location of your choosing, and include the autoloader:

``` php
require '/path/to/xsolla-autoloader.php';
```

## Quick Examples

### Integrate Payment UI

Generate Payment UI token:

``` php
<?php

use Xsolla\SDK\API\XsollaClient;

$client = XsollaClient::factory(array(
    'merchant_id' => MERCHANT_ID,
    'api_key' => 'API_KEY'
));
$paymentUIToken = $client->createCommonPaymentUIToken(PROJECT_ID, USER_ID, $sandboxMode = true);
```

Render Payment UI script in your page:

``` php
<html>
<head lang="en">
    <meta charset="UTF-8">
</head>
<body>
    <button data-xpaystation-widget-open>Test Button</button>
    
    <?php \Xsolla\SDK\API\PaymentUI\PaymentUIScriptRenderer::send($paymentUIToken); ?>
</body>
</html>
```

### Receive webhooks

``` php
<?php

use Xsolla\SDK\Webhook\WebhookServer;
use Xsolla\SDK\Webhook\Message\Message;
use Xsolla\SDK\Exception\Webhook\XsollaWebhookException;

$callback = function (Message $message) {
    switch ($message->getNotificationType()) {
        case Message::USER_VALIDATION:
            //check user existence
            break;
        case Message::PAYMENT:
            //handle payment
            break;
        case Message::REFUND:
            //handle refund
            break;
        default:
            throw new XsollaWebhookException('Notification type not implemented');
    }
};

$webhookServer = WebhookServer::create($callback, PROJECT_KEY); // https://merchant.xsolla.com/MERCHANT_ID/projects/PROJECT_ID/settings/connection
$webhookServer->start();
```

## Additional resources

* [Website](http://xsolla.com)
* [Documentation](http://developers.xsolla.com)
* [Status](http://status.xsolla.com)
* [Support and Feedback](mailto:api.developers@xsolla.com)