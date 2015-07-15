<?php

namespace Xsolla\SDK\Tests\Integration\API;

class SupportTest extends AbstractAPITest
{
    public function testListSupportTickets()
    {
        $response = $this->xsollaClient->ListSupportTickets();
        static::assertInternalType('array', $response);
    }

    public function testListSupportTicketComments()
    {
        static::markTestSkipped('TODO: add support ticket to test project');
    }
}