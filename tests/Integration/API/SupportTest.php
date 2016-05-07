<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class SupportTest extends AbstractAPITest
{
    public function testListSupportTickets()
    {
        $response = $this->xsollaClient->ListSupportTickets();
        static::assertInternalType('array', $response);
    }

    public function testListSupportTicketComments()
    {
        static::markTestIncomplete('TODO: add support ticket to test project');
    }
}
