<?php

namespace Xsolla\SDK\Tests\Integration\API;

class EventsTest extends AbstractAPITest
{
    public function testListEvents()
    {
        $events = $this->xsollaClient->ListEvents();
        static::assertInternalType('array', $events);
    }
}