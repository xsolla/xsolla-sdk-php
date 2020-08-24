# Xsolla SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/xsolla/xsolla-sdk-php/v/stable.png)](https://packagist.org/packages/xsolla/xsolla-sdk-php)
[![Build Status](https://travis-ci.org/xsolla/xsolla-sdk-php.png?branch=master)](https://travis-ci.org/xsolla/xsolla-sdk-php)
[![Code Coverage](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/?branch=master)
[![Downloads](https://poser.pugx.org/xsolla/xsolla-sdk-php/d/total.png)](https://packagist.org/packages/xsolla/xsolla-sdk-php)
[![Join the chat at https://gitter.im/xsolla/xsolla-sdk-php](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/xsolla/xsolla-sdk-php?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/xsolla/xsolla-sdk-php/master/LICENSE)

An official PHP SDK for interacting with [Xsolla API](https://developers.xsolla.com/api/)

![Payment UI screenshot](http://xsolla.cachefly.net/img/ps3_github2.png)

## Features

* Full customisation of Payment UI with the help of different methods of getting token.
* Client for all API methods, making your integration easy and convenient. You can use it for setting up and updating virtual currency, items and subscription plans, for managing the users balance, for checking the finance information with the help of Report API and so on.
* Convenient webhook server:
  * To start you need only one callback function.
  * All security checking already implemented: signature authentication and IP whitelisting.
  * Full customisation of notification processing logic, if standard server class doesn’t suit you.
* SDK is built on Guzzle v3, and utilizes many of its features, including persistent connections, parallel requests, events and plugins (via Symfony2 EventDispatcher), service descriptions, over-the-wire logging, caching, flexible batching, and request retrying with truncated exponential back off.

## Requirements

* PHP >=7.1.3 <= 7.4.5
* The following PHP extensions are required:
  * curl
  * json

## Getting Started

Please register your [Publisher Account](https://publisher.xsolla.com/signup) and create the project.
In order to use the PHP SDK Library you'll need:
* MERCHANT_ID
* API_KEY
* PROJECT_ID
* PROJECT_KEY

You can obtain these parameters using the information in your [Company Profile](https://publisher.xsolla.com/company) and [Project Settings](https://publisher.xsolla.com/projects).

## Installation

### Installing via Composer

The recommended way to install Xsolla SDK for PHP is through [Composer](http://getcomposer.org).

``` bash
$ cd /path/to/your/project
$ composer require xsolla/xsolla-sdk-php
```

After installing, you need to require Composer's autoloader:

```php
require '/path/to/vendor/autoload.php';
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

To integrate Payment UI into your game you should obtain an access token. An access token is a string that identifies game, user and purchase parameters.

There are number of ways for getting token. The easiest one is to use the _createCommonPaymentUIToken_ method, you will need to pass only ID of project in Xsolla system and ID of the user in your game:

``` php
<?php

use Xsolla\SDK\API\XsollaClient;

$client = XsollaClient::factory(array(
    'merchant_id' => MERCHANT_ID,
    'api_key' => API_KEY
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
    <button data-xpaystation-widget-open>Buy Credits</button>
    
    <?php \Xsolla\SDK\API\PaymentUI\PaymentUIScriptRenderer::send($paymentUIToken, $isSandbox = true); ?>
</body>
</html>
```
### Receive webhooks

There is a build in server class to help you to handle the webhooks.

```php
<?php

use Xsolla\SDK\Webhook\WebhookServer;
use Xsolla\SDK\Webhook\Message\Message;
use Xsolla\SDK\Exception\Webhook\XsollaWebhookException;

$callback = function (Message $message) {
    switch ($message->getNotificationType()) {
        case Message::USER_VALIDATION:
            /** @var Xsolla\SDK\Webhook\Message\UserValidationMessage $message */
            // TODO if user not found, you should throw Xsolla\SDK\Exception\Webhook\InvalidUserException
            break;
        case Message::PAYMENT:
            /** @var Xsolla\SDK\Webhook\Message\PaymentMessage $message */
            // TODO if the payment delivery fails for some reason, you should throw Xsolla\SDK\Exception\Webhook\XsollaWebhookException
            break;
        case Message::REFUND:
            /** @var Xsolla\SDK\Webhook\Message\RefundMessage $message */
            // TODO if you cannot handle the refund, you should throw Xsolla\SDK\Exception\Webhook\XsollaWebhookException
            break;
        default:
            throw new XsollaWebhookException('Notification type not implemented');
    }
};

$webhookServer = WebhookServer::create($callback, PROJECT_KEY);
$webhookServer->start();
```

Once you've finished the handling of notifications on your server, please set up the URL that will receive all webhook notifications on the Settings page for your project.

## Troubleshooting

You can find solutions for the most frequently encountered errors in our [documentation](https://developers.xsolla.com/doc/sdk/#php_sdk_troubleshooting).

## Contributing

Please take a look at the [CONTRIBUTING.md](CONTRIBUTING.md) to see how to get your changes merged in.

## Additional resources

* [Website](http://xsolla.com)
* [Documentation](http://developers.xsolla.com)
* [Status](http://status.xsolla.com)
* [Support and Feedback](mailto:integration@xsolla.com)
