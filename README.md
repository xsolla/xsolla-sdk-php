# Xsolla SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/xsolla/xsolla-sdk-php/v/stable.png)](https://packagist.org/packages/xsolla/xsolla-sdk-php)
[![Build Status](https://travis-ci.org/xsolla/xsolla-sdk-php.png?branch=master)](https://travis-ci.org/xsolla/xsolla-sdk-php)
[![Code Coverage](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/coverage.png?s=6961fe8e4895fe6292b981f53c2ebc8f89fb1309)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/quality-score.png?s=e04a6701a560d126eef80f33f8a1181372588472)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/44ae8284-c5c3-40f8-b1e3-de4093995db5/mini.png)](https://insight.sensiolabs.com/projects/44ae8284-c5c3-40f8-b1e3-de4093995db5)

An official PHP SDK for interacting with [Xsolla HTTP API](http://xsolla.github.io/)

## Requirements

* PHP 5.3.3+
* Your php.ini needs to have the date.timezone setting

## Installation

The recommended way to install Xsolla SDK for PHP is through [Composer](http://getcomposer.org).

``` bash
$ cd /path/to/your/project
$ composer require xsolla/xsolla-sdk-php:~1.0
```

## Usage

### Generate URL to [Paystation Widget](http://xsolla.github.io/en/plugindemonstration.html)

``` php
<?php

use Xsolla\SDK\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\PaymentPage\UrlBuilderFactory;

$project = new Project(
    '4783',//demo project id
    'key'//demo project secret key
 );
$urlBuilderFactory = new UrlBuilderFactory($project);

$user = new User('username');
$user->setEmail('example@example.com')
    ->setPhone('79090000000');

$invoice = new Invoice;
$invoice->setVirtualCurrencyAmount(5);

$url = $urlBuilderFactory->getCreditCards()
    ->setInvoice($invoice)
    ->setUser($user)
    ->unlockParameterForUser('email')
    ->setCountry('US')
    ->setLocale('fr')
    ->setParameter('description', 'Purchase description')
    ->getLink();

echo $url.PHP_EOL;
```
### Receive [Instant Payment Notification](http://xsolla.github.io/en/currency.html)

For receiving IPN requests you should implement [\Xsolla\SDK\Protocol\Storage](https://github.com/xsolla/xsolla-sdk-php/tree/master/src/Protocol/Storage) interfaces.
Also you can setup sql tables for your [protocol](http://xsolla.github.io/en/currency.html) from [resources/mysql](https://github.com/xsolla/xsolla-sdk-php/tree/master/resources/mysql) and use [\Xsolla\SDK\Protocol\Storage\Pdo](https://github.com/xsolla/xsolla-sdk-php/tree/master/src/Protocol/Storage/Pdo) classes directly or extend it.

``` php
<?php
$demoProject = new \Xsolla\SDK\Project(
    '4783',//demo project id
    'key'//demo project secret key
);

$dsn = sprintf('mysql:dbname=%s;host=%s;', 'YOUR_DB_NAME', 'YOUR_DB_HOST');
$pdo = new \PDO($dsn, 'YOUR_DB_USER', 'YOUR_DB_PASSWORD');
$usersStorage = new \Xsolla\SDK\Protocol\Storage\Pdo\UserStorage($pdo);
$paymentsStorage = new \Xsolla\SDK\Protocol\Storage\Pdo\PaymentStandardStorage($pdo);
$ipChecker = new \Xsolla\SDK\Validator\IpChecker;
$protocolBuilder = new \Xsolla\SDK\Protocol\ProtocolFactory($demoProject, $ipChecker);
$protocol = $protocolBuilder->getStandardProtocol($usersStorage, $paymentsStorage);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $protocol->run($request);
$response->send();
```
[IpChecker](https://github.com/xsolla/xsolla-sdk-php/blob/master/src/Validator/IpChecker.php) - additional security level for situations when your secret key is compromised.
It's a optional parameter for ProtocolFactory and you can skip it for development and testing environment.
If you use reverse proxy, you should set a list of trusted proxies via [Request::setTrustedProxies()](http://symfony.com/doc/current/components/http_foundation/trusting_proxies.html)

You can run IPN demo with the following commands(required php 5.4+ with built-in server):

``` bash
$ cd /path/to/xsolla/xsolla-sdk-php
$ composer install
$ php -S localhost:9000 -t example example/callbackStandard.php > /dev/null 2>&1 &
$ # no command
$ curl 'localhost:9000'
$ # user found
$ curl 'http://localhost:9000?command=check&v1=demo&v2=&v3=&md5=a3561b90df78828133eb285e36965419'
$ # user not found or disabled
$ curl 'http://localhost:9000?command=check&v1=not_exist&v2=&v3=&md5=5f67cabd3cf27cac2944e7f9f762a42a'
$ # success IPN handling. Response contain payment ID
$ curl 'http://localhost:9000?command=pay&id=1&v1=demo&v2=&v3=&date=2014-02-19+13%3A03%3A52&sum=1&md5=eae3e95e93ff64f72aeb9fadfd8f0d66'
$ # failed IPN handling. Unprocessable request error
$ curl 'http://localhost:9000?command=pay&id=2&v1=demo&v2=&v3=&date=2014-02-19+13%3A04%3A30&sum=5&md5=3067aeb81faa883f36d27acc9d808abb'
$ # success payment cancel
$ curl 'http://localhost:9000?command=cancel&id=3&md5=9ac4f238314b0a0dae5be98151d19f33'
```

More examples you can find in [example](https://github.com/xsolla/xsolla-sdk-php/tree/master/example) folder.

## Additional resources

* [Website](http://xsolla.com)
* [Documentation](http://xsolla.github.io)
* [Status](http://status.xsolla.com)