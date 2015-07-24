<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ReportsTest extends AbstractAPITest
{
    public function testListPaymentsRegistry()
    {
        static::markTestSkipped('TODO: 404');
    }

    public function testListTransfersRegistry()
    {
        $response = $this->xsollaClient->ListTransfersRegistry();
        static::assertInternalType('array', $response);
    }

    public function testListReportsRegistry()
    {
        $response = $this->xsollaClient->ListReportsRegistry();
        static::assertInternalType('array', $response);
    }

    public function testCreateRefundRequest()
    {
        static::markTestSkipped('TODO: 404');
    }
}