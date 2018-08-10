<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Response\PinCodeResponse;

/**
 * @group unit
 */
class PinCodeResponseTest extends TestCase
{
    public function testPinCodeHasInvalidType()
    {
        $this->expectException('\Xsolla\SDK\Exception\Webhook\XsollaWebhookException');
        $this->expectExceptionMessage('Pin code should be non-empty string. stdClass given');

        new PinCodeResponse(new \stdClass());
    }

    public function testPinCodeIsEmptyString()
    {
        $this->expectException('\Xsolla\SDK\Exception\Webhook\XsollaWebhookException');
        $this->expectExceptionMessage('Pin code should be non-empty string. NULL give');

        new PinCodeResponse(null);
    }

    public function testPinCodeIsNull()
    {
        $this->expectException('\Xsolla\SDK\Exception\Webhook\XsollaWebhookException');
        $this->expectExceptionMessage('Pin code should be non-empty string. Empty string given');

        new PinCodeResponse('');
    }

    public function testPinCodeResponse()
    {
        $response = new PinCodeResponse('pin_code');
        $this->assertJsonStringEqualsJsonString('{"pin_code":"pin_code"}', $response->getSymfonyResponse()->getContent());
    }
}
