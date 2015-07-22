<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class ReportsTest extends AbstractAPITest
{
    public function testListPaymentsRegistry()
    {
        static::markTestSkipped();
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
        static::markTestSkipped();
        return;//TODO 404 catch and skip + unit test
        $this->xsollaClient->CreateRefundRequest(array(
            'transaction_id' => 1,
            'request' => array(
                'description' => 'description',
            ),
        ));
    }
}