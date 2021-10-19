# Change Log
All notable changes to this project will be documented in this file.
## [Unreleased](https://github.com/xsolla/xsolla-sdk-php/compare/v4.2.0...master)
### Added
* [Non Renewal Subscription](https://developers.xsolla.com/api/getting-started/#api_webhooks_non_renewing_subscription) webhook method.

## [v4.2.0](https://github.com/xsolla/xsolla-sdk-php/compare/v4.1.2...v4.2.0) - 2021-05-12
### Added
* Changed support version of PHP to ^7.3|^8.0
* Changed version of phpunit/phpunit from ~7.3 to ^9.0
* Fixed null-return in AfsRejectMessage::getExternalPaymentId() (Missing 'return' statement)
* Fixed process creation in ServerTest::setUpPhpServer() (expected parameter of type 'array')
* Fixed "Qualifier can be replaced with an import"
* Fixed "Redundant default attribute value assignment" in phpunit.xml.dist

## [v4.1.2](https://github.com/xsolla/xsolla-sdk-php/compare/v4.1.1...v4.1.2) - 2020-10-09
### Added
* Changed support version of PHP from 7.1.3 to 7.4.x

## [v4.1.1](https://github.com/xsolla/xsolla-sdk-php/compare/v4.1.0...v4.1.1) - 2020-07-16
### Added
* Changed support version of PHP from 7.1.3 to 7.4.5
* Added support of symfony/http-foundation 5.0 version
* Added Laravel ^7.0 compatible

## [v4.1.0](https://github.com/xsolla/xsolla-sdk-php/compare/v4.0.2...v4.1.0) - 2019-11-29
### Added
* Changed support version of PHP from >=7.1.3 <7.3 to >=7.1.3 <=7.3

## [v4.0.2](https://github.com/xsolla/xsolla-sdk-php/compare/v4.0.1...v4.0.2) - 2018-12-04
### Added
* [Afs reject](https://developers.xsolla.com/api/v1/getting-started/#api_webhooks_afs_reject) webhook method.
* [User attributes](https://developers.xsolla.com/api/v1/getting-started/#api_payment_ui_get_token_user_attributes) for token request.

## [v4.0.1](https://github.com/xsolla/xsolla-sdk-php/compare/v4.0.0...v4.0.1) - 2018-09-18
### Fixed
* Phar and rar archive

## [v4.0.0](https://github.com/xsolla/xsolla-sdk-php/compare/v3.3.0...v4.0.0) - 2018-09-14
### Fixed
* Update guzzle version from 5.3 to 6.0
* Change code and tests for new guzzle version
* Change phar build
* Change debug output format for tests

## [v3.3.0](https://github.com/xsolla/xsolla-sdk-php/compare/v3.2.0...v3.3.0) - 2018-09-14
### Fixed
* Update version of guzzle from 3.8 to 5.3
* Fixed descriptions of methods

### Added
* Test for check exception of guzzle

## [v3.2.0](https://github.com/xsolla/xsolla-sdk-php/compare/v3.1.0...v3.2.0) - 2018-09-11
### Added
* Method UpdatePromotionCampaigns
* Tests

### Fixed
* Dates of license
* Descriptions of methods

## [v3.1.0](https://github.com/xsolla/xsolla-sdk-php/compare/v3.0.3...3.1.0) - 2018-09-05
### Added
* Methods CreateCouponPromotion, ListCouponPromotions, CreateCoupon
* Tests
* Fixation version of api

### Fixed
* Date of releases

## [v3.0.3](https://github.com/xsolla/xsolla-sdk-php/compare/v3.0.2...v3.0.3) - 2018-09-04
### Added
* Backward compatibility for symfony < 4.0

## [v3.0.2](https://github.com/xsolla/xsolla-sdk-php/compare/v3.0.1...v3.0.2) - 2018-08-17
### Fixed
* Fixed tests

## [v3.0.1](https://github.com/xsolla/xsolla-sdk-php/compare/v3.0.0...v3.0.1) - 2018-08-17
### Fixed
* Changed php images at .travis.yml (add php72, php71, delete old php versions)
* Changed README.md

## [v3.0.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.6.2...v3.0.0) - 2018-08-10
### Added
* Changed support version of php from 5.* to 7.1.*

## [v2.6.2](https://github.com/xsolla/xsolla-sdk-php/compare/v2.6.1...v2.6.2) - 2017-07-07
### Updated
* Updated version of the paystation widget used to open the lightbox from 1.0.2 to 1.0.7.

## [v2.6.1](https://github.com/xsolla/xsolla-sdk-php/compare/v2.6.0...v2.6.1) - 2016-10-26
### Fixed
* Added missing parameters for GET requests

## [v2.6.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.5.0...v2.6.0) - 2016-05-31
### Added
* Added public user id processing for [User Search](http://developers.xsolla.com/api.html#user-search) webhook method.
* Added support for [Saved Payment Accounts](http://developers.xsolla.com/api.html#direct-payments) API methods to `XsollaClient`.

## [v2.5.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.4.1...v2.5.0) - 2016-05-18
### Added
* Added support for [Project Settings](http://developers.xsolla.com/api.html#project-settings) API methods to `XsollaClient`.

## [v2.4.1](https://github.com/xsolla/xsolla-sdk-php/compare/v2.4.0...v2.4.1) - 2016-05-11
### Fixed
* [BC BREAK] Added required integer parameters `limit` and `offset` to `XsollaClient::ListEvents`.
* [BC BREAK] Renamed Frontend API to [Storefront](http://developers.xsolla.com/api.html#storefront)

## [v2.4.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.3.0...v2.4.0) - 2016-04-27
### Added
* Added [Frontend API](http://developers.xsolla.com/api.html#paystation) http methods.
* Added [Update Subscription](http://developers.xsolla.com/api.html#renew-subscription) webhook method.

## [v2.3.0](https://github.com/xsolla/xsolla-sdk-php/compare/v2.2.0...v2.3.0) - 2016-02-03
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
