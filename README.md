> [!WARNING]
> **This repository is deprecated and is no longer actively maintained.**
>
> If you arrived here from a web search, you are looking at a legacy Xsolla PHP SDK. Use the current **Xsolla SDK** and API documentation instead — they provide up-to-date server-side integration guides with active support.
>
> - 📖 **[Xsolla SDK Documentation](https://developers.xsolla.com/sdk/)** — get started with the current integration
> - 🔭 **[SDK Explorer](https://developers.xsolla.com/sdk/demo/)** — try the SDK interactively before writing any code

# Xsolla SDK for PHP

![License](https://img.shields.io/github/license/xsolla/xsolla-sdk-php)
![Latest release](https://img.shields.io/github/v/release/xsolla/xsolla-sdk-php)

## Overview

The Xsolla SDK for PHP is a server-side library for working with the [Xsolla API](https://developers.xsolla.com/#api). It provides ready-to-use classes for processing webhooks (`user_validation`, `payment`, `refund`) with signature authentication and IP whitelisting built in, plus a client for the Xsolla API methods (virtual currency, items, subscription plans, user balance, Report API, and more).

It is intended for backend developers integrating Xsolla payments and webhook handling into a PHP application.

## Requirements

- PHP 7.3 or 8.0+
- PHP extensions: `curl`, `json`
- An [Xsolla Publisher Account](https://publisher.xsolla.com/signup) project (provides `MERCHANT_ID`, `API_KEY`, `PROJECT_ID`, `PROJECT_KEY`)

## Install

Install via [Composer](https://getcomposer.org):

```bash
composer require xsolla/xsolla-sdk-php
```

Then require Composer's autoloader:

```php
require '/path/to/vendor/autoload.php';
```

## Usage

Handle Xsolla webhooks with the built-in webhook server — a single callback covers user validation, payment, and refund notifications:

```php
use Xsolla\SDK\Webhook\WebhookServer;
use Xsolla\SDK\Webhook\Message\Message;
use Xsolla\SDK\Webhook\Message\NotificationTypeDictionary;

$callback = function (Message $message) {
    switch ($message->getNotificationType()) {
        case NotificationTypeDictionary::USER_VALIDATION:
            // verify the user exists
            break;
        case NotificationTypeDictionary::PAYMENT:
            // deliver the purchase
            break;
        case NotificationTypeDictionary::REFUND:
            // handle the refund
            break;
    }
};

$webhookServer = WebhookServer::create($callback, PROJECT_KEY);
$webhookServer->start();
```

## Documentation

- Full PHP SDK docs: [developers.xsolla.com/doc/sdk](https://developers.xsolla.com/doc/sdk/)
- Developer portal: [developers.xsolla.com](https://developers.xsolla.com)

## Support

- **GitHub Issues:** [github.com/xsolla/xsolla-sdk-php/issues](https://github.com/xsolla/xsolla-sdk-php/issues)
- **Developer portal:** [developers.xsolla.com](https://developers.xsolla.com)

## License

MIT License. See [LICENSE](./LICENSE).
