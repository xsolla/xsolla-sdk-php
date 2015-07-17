# Xsolla SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/xsolla/xsolla-sdk-php/v/stable.png)](https://packagist.org/packages/xsolla/xsolla-sdk-php)
[![Build Status](https://travis-ci.org/xsolla/xsolla-sdk-php.png?branch=master)](https://travis-ci.org/xsolla/xsolla-sdk-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/quality-score.png?b=v2)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php)
[![Join the chat at https://gitter.im/xsolla/xsolla-sdk-php](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/xsolla/xsolla-sdk-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/xsolla/xsolla-sdk-php/master/LICENSE)

An official PHP SDK for interacting with [Xsolla API](http://developers.xsolla.com)

![Payment UI screenshot](https://xsolla.cachefly.net/img/ps3_github.png)

## Features

## Getting started

## Requirements

* PHP 5.3.9+
* Your php.ini needs to have the date.timezone setting
* The following PHP extensions are required:
  * curl
  * json

## Installation

The recommended way to install Xsolla SDK for PHP is through [Composer](http://getcomposer.org).

``` bash
$ cd /path/to/your/project
$ composer require xsolla/xsolla-sdk-php:~2.0
```

## Quick Examples

### Generate Payment UI Token

``` php
<?php

use Xsolla\SDK\API\XsollaClient;

$client = XsollaClient::factory(array(
    'merchant_id' => MERCHANT_ID,
    'api_token' => 'API_KEY'
));
$paymentUIToken = $client->createCommonPaymentUIToken(PROJECT_ID, USER_ID);
```

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

use Xsolla\SDK\IPN\IPNServer;
use Xsolla\SDK\IPN\Message\Message;

$callback = function (Message $message) {
    switch ($message->getNotificationType()) {
        case Message::IPN_USER_VALIDATION:
            //check user existence
            break;
        case Message::IPN_PAYMENT:
            //handle payment
            break;
        case Message::IPN_REFUND:
            //handle refund
            break;
        default:
            throw new XsollaIPNException('Notification type not implemented');
    }
};

$IPNServer = IPNServer::create($callback, PROJECT_KEY); // https://merchant.xsolla.com/MERCHANT_ID/projects/PROJECT_ID/settings/connection
$IPNServer->start();
```

## Additional resources

* [Website](http://xsolla.com)
* [Documentation](http://developers.xsolla.com)
* [Status](http://status.xsolla.com)