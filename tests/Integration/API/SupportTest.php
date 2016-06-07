<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class SupportTest extends AbstractAPITest
{
    public function testListSupportTickets()
    {
        $response = static::$xsollaClient->ListSupportTickets();
        static::assertInternalType('array', $response);
    }

    public function testListSupportTicketComments()
    {
        static::markTestIncomplete('We haven\'t support tickets in test account for comments testing.');
    }
}
