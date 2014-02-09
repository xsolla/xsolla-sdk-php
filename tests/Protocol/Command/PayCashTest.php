<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\PayCash;

class PayCashTest extends CommandTest
{
    protected $signParams = array('v1', 'amount', 'currency', 'id');
    protected $signParamName = 'sign';

    public function setUp()
    {
        parent::setUp();
        $this->command = new PayCash($this->projectMock, $this->paymentsCashMock);
        $this->request = array(
            'id' => 'example_id',
            'amount' => 'example_amount',
            'v1' => 'example_v1',
            'v2' => 'example_v2',
            'v3' => 'example_v3',
            'currency' => 'example_currency',
            'datetime' => '20131212110000',
            'userAmount' => 'example_userAmount',
            'userCurrency' => 'example_userCurrency',
            'transferAmount' => 'example_transferAmount',
            'transferCurrency' => 'example_transferCurrency',
            'pid' => 'example_pid',
            'geotype' => 'example_geotype'
        );
        $this->queryBag->replace($this->request);
    }

    public function testCheckSign()
    {
        $request = array(
            'v1' => 'v1',
            'amount' => '123',
            'currency' => 'RUR',
            'id' => '456'
        );
        $this->checkSignTest($request);
    }

    /**
     * @dataProvider dryRunDataProvider
     */
    public function testProcess($dryRunQueryParameter, $expectedDryRun)
    {
        if (!is_null($dryRunQueryParameter)) {
            $this->queryBag->set('dry_run', $dryRunQueryParameter);
        }
        $this->paymentsCashMock->expects($this->once())
            ->method('pay')
            ->with(
                'example_id',
                'example_amount',
                'example_v1',
                'example_v2',
                'example_v3',
                'example_currency',
                new \DateTime('2013-12-12 11:00:00'),
                $expectedDryRun,
                'example_userAmount',
                'example_userCurrency',
                'example_transferAmount',
                'example_transferCurrency',
                'example_pid',
                'example_geotype'
            );
        $result = $this->command->process($this->requestMock);

        $this->assertEquals(PayCash::CODE_SUCCESS, $result['result']);
    }

    public function testProcessWithInvalidDateTime()
    {
        $invalidDateTimeFormat = '2014-01-01 01:01:01';
        $this->queryBag->set('datetime', $invalidDateTimeFormat);
        $result = $this->command->process($this->requestMock);
        $this->assertEquals(PayCash::CODE_ERROR_TEMPORARY, $result['result']);
        $this->assertContains($invalidDateTimeFormat, $result['description']);
    }

    public function testProcessWithFail()
    {
        $this->paymentsCashMock->expects($this->once())
            ->method('pay')
            ->will($this->throwException(new \Exception('Message')));
        $result = $this->command->process($this->requestMock);

        $this->assertEquals(PayCash::CODE_ERROR_TEMPORARY, $result['result']);
        $this->assertEquals('Message', $result['description']);
    }
}
