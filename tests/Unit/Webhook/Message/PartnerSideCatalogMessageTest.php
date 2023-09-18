<?php

namespace Xsolla\SDK\Tests\Unit\Webhook\Message;

use PHPUnit\Framework\TestCase;
use Xsolla\SDK\Webhook\Message\PartnerSideCatalogMessage;

class PartnerSideCatalogMessageTest extends TestCase
{
    protected $request = [
        'notification_type' => 'partner_side_catalog',
        'user' => [
            'id' => '1234567',
            'country' => 'ZZ',
            'currency' => 'ZUB',
        ],
    ];

    public function test()
    {
        $message = new PartnerSideCatalogMessage($this->request);
        static::assertSame($this->request['user'], $message->getUser());
    }
}