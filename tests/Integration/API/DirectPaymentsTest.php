<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class DirectPaymentsTest extends AbstractAPITest
{
    public function testCreatePaymentAccount()
    {
        static::markTestSkipped();
        return;//TODO
       $response = $this->xsollaClient->CreatePaymentAccount(array(
           'project_id' => $this->projectId,
           'user_id' => 1,
           'request' => array(
               'currency' => 'USD',
               'user' => array(
                   'ip' => '127.0.0.1'
               ),
               'card' => array(
                   'number' => '4242424242424242',
                   'month' => 12,
                   'year' => 2030,
                   'cvn' => 123,
               ),
           ),
       ));
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