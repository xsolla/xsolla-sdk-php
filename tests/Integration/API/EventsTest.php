<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class EventsTest extends AbstractAPITest
{
    public function testListEvents()
    {
        $events = $this->xsollaClient->ListEvents(array(
            'limit' => 5,
            'offset' => 0,
        ));
        static::assertInternalType('array', $events);
    }
}
