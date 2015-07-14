# Xsolla SDK for PHP

## Requirements

* PHP 5.3.3+
* Your php.ini needs to have the date.timezone setting

## Installation

The recommended way to install Xsolla SDK for PHP is through [Composer](http://getcomposer.org).

``` bash
$ cd /path/to/your/project
$ composer require xsolla/xsolla-sdk-php:~2.0
```

## Usage

### Generate Payment UI Token

``` php
<?php
require_once 'vendor/autoload.php';

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

### Receive IPN (Instant Payment Notification)

``` php
<?php
require_once 'vendor/autoload.php';

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