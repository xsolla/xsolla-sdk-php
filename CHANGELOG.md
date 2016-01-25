# Change Log
All notable changes to this project will be documented in this file.

## [v2.2.1](https://github.com/xsolla/xsolla-sdk-php/compare/v2.2.1...v2.2.0) - 2016-01-25
### Added
* Added [Get Pin Code](http://developers.xsolla.com/api.html#get-pin-code) webhook method.

## [v2.2.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.1.0...v2.2.0) - 2016-01-13
### Added
* Added [Game Delivery](http://developers.xsolla.com/api.html#game-delivery) methods to `XsollaClient`.

### Removed
* [BC BREAK] Removed deprecated methods `UpdateVirtualItemImage`, `DeleteVirtualItemImage` from `XsollaClient`.

## [v2.1.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.0.0...v2.1.0) - 2015-09-29
### Added
* Added `TokenRequest::setPurchase($amount, $currency)` method for [Simple Checkout module](http://developers.xsolla.com/#simple-checkout)

## [v2.0.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.0.0-BETA1...v2.0.0) - 2015-08-10
### Added
* Added `XsollaClient::SearchPaymentsRegistry` method for getting a transaction list based on specific search parameters.

### Fixed
* Fixed various TLS cURL errors, e.g. '77: error setting certificate verify locations'. Guzzle TLS default options replaced with cURL OS defaults.
* Set `format`, `datetime_from`, `datetime_to`, `limit`, `offset`, `in_transfer_currency`, `show_total` as required parameters in `XsollaClient::ListPaymentsRegistry`

### Changed
* Added optional argument `$sandboxMode` to `XsollaClient::createCommonPaymentUIToken`
* [BC BREAK] `XsollaClient::ListSubscriptionPayments` returns subscription payments for all users; `user_id` parameter removed. Added `ListUserSubscriptionPayments` instead `ListSubscriptionPayments` with same parameters.
* [BC BREAK] Changed `plan_id` type in Subscriptions API from `string` to `int`

## [v2.0.0-BETA1](https://github.com/xsolla/xsolla-sdk-php/compare/v1.1.1...v2.0.0-BETA1) - 2015-07-27
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