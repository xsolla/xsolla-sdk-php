<?php

namespace Xsolla\SDK\Tests\Integration\API;

class ReportsTest extends AbstractAPITest
{
    public function testListPayments()
    {
        static::markTestSkipped();
    }

    public function testListTransfers()
    {
        $response = $this->xsollaClient->ListTransfers();
        static::assertInternalType('array', $response);
    }

    public function testListReports()
    {
        $response = $this->xsollaClient->ListReports();
        static::assertInternalType('array', $response);
    }

    public function testCreateRefundRequest()
    {
        static::markTestSkipped();
    }
}