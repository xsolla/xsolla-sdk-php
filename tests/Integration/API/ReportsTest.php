<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ReportsTest extends AbstractAPITest
{
    public function testSearchPaymentsRegistry()
    {
        $response = static::$xsollaClient->SearchPaymentsRegistry([
            'format' => 'json',
            'type' => 'all',
            'limit' => 2,
            'offset' => 0,
        ]);
        static::assertIsArray($response);
    }

    public function testSearchPaymentsRegistryWithParams()
    {
        $response = static::$xsollaClient->SearchPaymentsRegistry([
            'format' => 'json',
            'type' => 'all',
            'limit' => 2,
            'offset' => 0,
            'status' => 'created',
        ]);
        static::assertIsArray($response);
    }

    public function testListPaymentsRegistry()
    {
        $response = static::$xsollaClient->ListPaymentsRegistry([
            'format' => 'json',
            'datetime_from' => '2015-01-01',
            'datetime_to' => '2015-01-02',
            'in_transfer_currency' => false,
            'limit' => 2,
            'offset' => 0,
            'show_total' => true,
            'status' => 'done',
        ]);
        static::assertIsArray($response);
    }

    public function testListTransfersRegistry()
    {
        $response = static::$xsollaClient->ListTransfersRegistry();
        static::assertIsArray($response);
    }

    public function testListReportsRegistry()
    {
        $response = static::$xsollaClient->ListReportsRegistry();
        static::assertIsArray($response);
    }

    public function testCreateRefundRequest()
    {
        static::markTestIncomplete('We haven\'t payments in test account for refund testing.');
    }
}
