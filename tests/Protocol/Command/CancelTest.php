<?php

namespace Xsolla\SDK\tests\Protocol\Command;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Protocol\Command\Cancel;

class CancelTest extends CommandTest
{
    const ID = 'example_id';

    protected $signParams = array('command', 'id');

    public function setUp()
    {
        parent::setUp();
        $this->command = new Cancel($this->projectMock, $this->paymentsStandardMock);
        $this->queryBag->set('id', 'example_id');
    }

    public function testCheckSign()
    {
        $request = array(
            'command' => 'cancel',
            'id' => '456'
        );
        $this->checkSignTest($request);
    }

    public function testProcess()
    {
        $this->paymentsStandardMock->expects($this->once())
            ->method('cancel')
            ->with(self::ID)
            ->will($this->returnValue(true));
        $result = $this->command->process($this->requestMock);

        $this->assertEquals($result['result'], 0);
    }

    public function testProcessInvoiceNotFound()
    {
        $this->paymentsStandardMock->expects($this->once())
            ->method('cancel')
            ->with(self::ID)
            ->will($this->throwException(new InvoiceNotFoundException()));
        $result = $this->command->process($this->requestMock);

        $this->assertEquals($result['result'], 2);
    }

    public function testProcessInvoiceNotBeRollback()
    {
        $this->paymentsStandardMock->expects($this->once())
            ->method('cancel')
            ->with(self::ID)
            ->will($this->throwException(new UnprocessableRequestException()));
        $result = $this->command->process($this->requestMock);

        $this->assertEquals($result['result'], 7);
    }
}
