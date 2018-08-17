<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use Xsolla\SDK\Webhook\Message\GetPinCodeMessage;

/**
 * @group unit
 */
class GetPinCodeMessageTest extends \PHPUnit_Framework_TestCase
{
    protected $request = array(
        'user' => array(
                'name' => 'Xsolla User',
                'id' => '1234567',
            ),
        'notification_type' => 'get_pincode',
        'pin_code' => array(
            'digital_content' => 'test123',
            'DRM' => 'steam',
        ),
    );

    public function test()
    {
        $message = new GetPinCodeMessage($this->request);
        static::assertSame($this->request['pin_code']['digital_content'], $message->getDigitalContent());
        static::assertSame($this->request['pin_code']['DRM'], $message->getDRM());
    }
}
