<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ReportsTest extends AbstractAPITest
{
    public function testSearchPaymentsRegistry()
    {
        $response = static::$xsollaClient->SearchPaymentsRegistry(array(
            'format' => 'json',
            'type' => 'all',
            'limit' => 2,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListPaymentsRegistry()
    {
        $response = static::$xsollaClient->ListPaymentsRegistry(array(
            'format' => 'json',
            'datetime_from' => '2015-01-01T00:00:00 UTC',
            'datetime_to' => '2015-01-02T00:00:00 UTC',
            'in_transfer_currency' => false,
            'limit' => 2,
            'offset' => 0,
            'show_total' => true,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListTransfersRegistry()
    {
        $response = static::$xsollaClient->ListTransfersRegistry();
        static::assertInternalType('array', $response);
    }

    public function testListReportsRegistry()
    {
        $response = static::$xsollaClient->ListReportsRegistry();
        static::assertInternalType('array', $response);
    }

    public function testCreateRefundRequest()
    {
        static::markTestIncomplete('We haven\'t payments in test account for refund testing.');
    }
}
