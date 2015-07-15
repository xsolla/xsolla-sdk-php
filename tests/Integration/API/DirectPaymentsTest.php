<?php

namespace Xsolla\SDK\Tests\Integration\API;

class DirectPaymentsTest extends AbstractAPITest
{
    public function testCreatePaymentAccount()
    {
        static::markTestSkipped();
    }

    public function testDeletePaymentAccount()
    {
        static::markTestSkipped();
    }

    public function testListPaymentAccounts()
    {
        $response = $this->xsollaClient->ListPaymentAccounts(array(
            'project_id' => $this->projectId,
            'user_id' => 1,
        ));
        static::assertInternalType('array', $response);
    }

    public function testMakePayment()
    {
        static::markTestSkipped();
    }

    public function testMakeCreditCardPayment()
    {
        static::markTestSkipped();
    }
}