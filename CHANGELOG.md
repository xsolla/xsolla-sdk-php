# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased](https://github.com/xsolla/xsolla-sdk-php/compare/v1.1.1...master)
### Added
* Simplified `XsollaClient` and `TokenRequest` methods for obtaining [Payment UI token](http://developers.xsolla.com/api.html#payment-ui)
* `WebhookServer` for receiving [notifications from Xsolla](http://developers.xsolla.com/api.html#notifications) 
* [All API methods](http://developers.xsolla.com/api.html) available through `XsollaClient`

### Removed
* Removed all deprecated functionality from [previous API version](http://xsolla.github.io/en/)

## [v1.1.1](https://github.com/xsolla/xsolla-sdk-php/compare/v1.1.0...v1.1.1) - 2014-08-05
* add payment_amount, payment_currency to default locked parameters list for generation of paystation2 payment page url

## [v1.1.0](https://github.com/xsolla/xsolla-sdk-php/compare/v1.0.4...v1.1.0) - 2014-07-24
* add Shopping Cart Protocol 3.0 http://xsolla.github.io/en/shopingcart3.html

## [v1.0.4](https://github.com/xsolla/xsolla-sdk-php/compare/v1.0.3...v1.0.4) - 2014-06-04
* fix incorrect sign code for Shopping Cart Protocol 2.0
* add `$reasonCode` and `$reasonDescription` optional arguments to `PaymentStorageInterface::cancel`

## [v1.0.3](https://github.com/xsolla/xsolla-sdk-php/compare/v1.0.2...v1.0.3) - 2014-04-22
* added missed sandbox key to UrlBuilder for sandbox-secure.xsolla.com
* fixed wrong error code for IPN requests with zero valued parameters

## [v1.0.2](https://github.com/xsolla/xsolla-sdk-php/compare/v1.0.1...v1.0.2) - 2014-02-27
* add `$baseUrl` optional argument to `UrlBuilder::getUrl()` and `UrlBuilder::SANDBOX_URL` constant

## [v1.0.1](https://github.com/xsolla/xsolla-sdk-php/compare/v1.0.0...v1.0.1) - 2014-02-25
* fix `description` response field name for UnprocessableRequestException handling in Shopping Cart protocol
* fix repeated notifications handling in Shopping Cart protocol