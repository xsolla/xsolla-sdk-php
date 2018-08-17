<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class EventsTest extends AbstractAPITest
{
    public function testListEvents()
    {
        $events = static::$xsollaClient->ListEvents(array(
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $events);
    }
}
