<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ReportsTest extends AbstractAPITest
{
    public function testSearchPaymentsRegistry()
    {
        $response = $this->xsollaClient->SearchPaymentsRegistry(array(
            'format' => 'json',
            'type' => 'all',
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListPaymentsRegistry()
    {
        $response = $this->xsollaClient->ListPaymentsRegistry(array(
            'format' => 'json',
            'datetime_from' => '2015-01-01T00:00:00 UTC',
            'datetime_to' => '2015-01-02T00:00:00 UTC',
            'in_transfer_currency' => false,
            'limit' => 1,
            'offset' => 0,
            'show_total' => true,
        ));
        static::assertInternalType('array', $response);
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
        static::markTestIncomplete('TODO: 404');
    }
}
