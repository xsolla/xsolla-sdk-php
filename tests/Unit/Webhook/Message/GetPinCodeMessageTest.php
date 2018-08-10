<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\GetPinCodeMessage;

/**
 * @group unit
 */
class GetPinCodeMessageTest extends TestCase
{
    protected $request = [
        'user' => [
                'name' => 'Xsolla User',
                'id' => '1234567',
            ],
        'notification_type' => 'get_pincode',
        'pin_code' => [
            'digital_content' => 'test123',
            'DRM' => 'steam',
        ],
    ];

    public function test()
    {
        $message = new GetPinCodeMessage($this->request);
        static::assertSame($this->request['pin_code']['digital_content'], $message->getDigitalContent());
        static::assertSame($this->request['pin_code']['DRM'], $message->getDRM());
    }
}
