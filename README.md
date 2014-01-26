# Xsolla SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/xsolla/xsolla-sdk-php/v/stable.png)](https://packagist.org/packages/xsolla/xsolla-sdk-php)
[![Build Status](https://travis-ci.org/xsolla/xsolla-sdk-php.png?branch=master)](https://travis-ci.org/xsolla/xsolla-sdk-php)
[![Code Coverage](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/coverage.png?s=6961fe8e4895fe6292b981f53c2ebc8f89fb1309)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/badges/quality-score.png?s=e04a6701a560d126eef80f33f8a1181372588472)](https://scrutinizer-ci.com/g/xsolla/xsolla-sdk-php/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/44ae8284-c5c3-40f8-b1e3-de4093995db5/mini.png)](https://insight.sensiolabs.com/projects/44ae8284-c5c3-40f8-b1e3-de4093995db5)

A official PHP SDK for interacting with the [Xsolla HTTP API](http://xsolla.github.io/)

## Requirements

* PHP 5.3.3+
* PHP [cURL extension](http://php.net/manual/en/curl.installation.php) with SSL enabled (it's usually built-in).

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

use Xsolla\SDK\Storage\Project;
use Xsolla\SDK\User;
use Xsolla\SDK\Invoice;
use Xsolla\SDK\Widget\Paystation

$project = new Project('YOUR_PROJECT_ID', 'YOUR_SECRET_KEY');
$paystation = new Paystation($project);

$user = new User('username');
$user->setEmail('example@example.com');

$invoice = new Invoice;
$invoice->setSum(5);
$invoice->setCurrency('USD');

echo $paystation->getLink($user, $invoice).PHP_EOL;
```
### Receive [Instant Payment Notification](http://xsolla.github.io/en/currency.html)

``` php
<?php


```

More examples you can find in `example` folder.

## Additional resources

* [Website](http://xsolla.com)
* [Documentation](http://xsolla.github.io)
* [Status](http://status.xsolla.com)