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
        static::assertIsArray($response);
    }

    public function testListSupportTicketsWithParams()
    {
        $response = static::$xsollaClient->ListSupportTickets([
            'merchant_id' => static::$merchantId,
            'datetime_from' => '2015-01-01T00:00:00Z',
            'datetime_to' => '2015-01-02T00:00:00Z',
            'status' => 'solved',
            'type' => 'question',
            'offset' => 0,
            'limit' => 100,
            'sender' => 'user',
        ]);
        static::assertIsArray($response);
    }

    public function testListSupportTicketComments()
    {
        static::markTestIncomplete('We haven\'t support tickets in test account for comments testing.');
    }
}
