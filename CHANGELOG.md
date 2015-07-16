# CHANGELOG

## 2.0 (2015-07-16)
*

## 1.1.1 (2014-08-05)
* add payment_amount, payment_currency to default locked parameters list for generation of paystation2 payment page url

## 1.1.0 (2014-07-24)
* add Shopping Cart Protocol 3.0 http://xsolla.github.io/en/shopingcart3.html

## 1.0.4 (2014-06-04)
* fix incorrect sign code for Shopping Cart Protocol 2.0
* add `$reasonCode` and `$reasonDescription` optional arguments to `PaymentStorageInterface::cancel`

## 1.0.3 (2014-04-22)
* added missed sandbox key to UrlBuilder for sandbox-secure.xsolla.com
* fixed wrong error code for IPN requests with zero valued parameters

## 1.0.2 (2014-02-27)
* add `$baseUrl` optional argument to `UrlBuilder::getUrl()` and `UrlBuilder::SANDBOX_URL` constant

## 1.0.1 (2014-02-25)
* fix `description` response field name for UnprocessableRequestException handling in Shopping Cart protocol
* fix repeated notifications handling in Shopping Cart protocol