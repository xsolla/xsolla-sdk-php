<?php

namespace Xsolla\SDK\Webhook\Response;

use Xsolla\SDK\API\XsollaClient;
use Xsolla\SDK\Exception\Webhook\XsollaWebhookException;
use Xsolla\SDK\Webhook\WebhookResponse;

class PinCodeResponse extends WebhookResponse
{
    public function __construct($pinCode)
    {
        if (!is_string($pinCode)) {
            throw new XsollaWebhookException(sprintf(
                'Pin code should be non-empty string. %s given',
                is_object($pinCode) ? get_class($pinCode) : gettype($pinCode)
            ));
        }
        if ('' === $pinCode) {
            throw new XsollaWebhookException('Pin code should be non-empty string. Empty string given');
        }
        parent::__construct(200, XsollaClient::jsonEncode(array('pin_code' => $pinCode)));
    }
}
