<?php

namespace Xsolla\SDK\Tests\Webhook\Message;

use Xsolla\SDK\Webhook\Response\PinCodeResponse;

/**
 * @group unit
 */
class PinCodeResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testPinCodeHasInvalidType()
    {
        $this->setExpectedException(
            '\Xsolla\SDK\Exception\Webhook\XsollaWebhookException',
            'Pin code should be non-empty string. stdClass given'
        );
        new PinCodeResponse(new \StdClass());
    }

    public function testPinCodeIsEmptyString()
    {
        $this->setExpectedException(
            '\Xsolla\SDK\Exception\Webhook\XsollaWebhookException',
            'Pin code should be non-empty string. NULL given'
        );
        new PinCodeResponse(null);
    }

    public function testPinCodeIsNull()
    {
        $this->setExpectedException(
            '\Xsolla\SDK\Exception\Webhook\XsollaWebhookException',
            'Pin code should be non-empty string. Empty string given'
        );
        new PinCodeResponse('');
    }

    public function testPinCodeResponse()
    {
        $response = new PinCodeResponse('pin_code');
        $this->assertJsonStringEqualsJsonString(
            '{"pin_code":"pin_code"}',
            $response->getSymfonyResponse()->getContent()
        );
    }
}
