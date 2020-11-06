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

To make integration with [Xsolla API](https://developers.xsolla.com/ru/api/) easier, use Pay Station PHP SDK on your server. SDK provides you with ready solutions for getting a token and processing webhooks. You can also use the Pay Station PHP SDK to realize the following functions in your app:

*   managing virtual currency packages
*   managing in-game items
*   managing renewable subscriptions
*   managing the user’s balance
*   reconciling financial data

After integrating Pay Station PHP SDK, you can do the following:

*   integrate all Xsolla API methods with a single client
*   use the simplified and advanced methods of getting a token
*   use a convenient app for processing requests from Xsolla servers

## System Requirements

*   PHP 7.1.3 - 7.4
*   PHP extensions:
    *   curl
    *   json


## Get Started

Before you start, you need to register your [Publisher Account](https://publisher.xsolla.com/signup) and create a project. During the installation process, you will need the following parameters from your Publisher Account:



*   Merchant ID
*   API key
*   Project ID
*   Secret key

Read more about prerequisites at [Xsolla Developers portal](https://developers.xsolla.com/sdk/others/php/).

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

## Usage

See instructions on how to get a token, open the payment UI, and handle webhooks at [Xsolla Developers portal](https://developers.xsolla.com/sdk/others/php/).


## Troubleshooting

You can find solutions for the most frequently encountered errors in our [documentation](https://developers.xsolla.com/sdk/others/php/#php_pay_station_sdk_troubleshooting).


## Contributing

Take a look at the [CONTRIBUTING.md](https://github.com/xsolla/xsolla-sdk-php/blob/master/CONTRIBUTING.md) to see how to merge your changes.


## Additional resources

*   [Xsolla website](http://xsolla.com/)
*   [Xsolla documentation](http://developers.xsolla.com/)
*   [Xsolla status](http://status.xsolla.com/)
*   [Xsolla Support and Feedback](mailto:integration@xsolla.com)
