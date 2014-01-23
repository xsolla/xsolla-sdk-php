<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Exception\InvoiceNotBeRollbackException;
use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Protocol\Command\Cancel;

class CancelTest extends CommandTest
{

    protected $signParams = array('command', 'id');

    public function setUp()
    {
        parent::setUp();

        $this->command = new Cancel($this->projectMock, $this->paymentsStandardMock);
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
        $this->requestMock->expects($this->once())->method('get')->with('id')->will($this->returnValue('id'));
        $this->paymentsStandardMock->expects($this->once())->method('cancel')->with('id')->will($this->returnValue(true));
        $result = $this->command->process($this->requestMock);

        $this->assertArrayHasKey('result', $result);
        $this->assertEquals($result['result'], 0);
    }

    public function testProcessInvoiceNotFound()
    {
        $this->requestMock->expects($this->once())->method('get')->with('id')->will($this->returnValue('id'));
        $this->paymentsStandardMock->expects($this->once())->method('cancel')->with('id')->will($this->throwException(new InvoiceNotFoundException()));
        $result = $this->command->process($this->requestMock);

        $this->assertArrayHasKey('result', $result);
        $this->assertEquals($result['result'], 2);
    }

    public function testProcessInvoiceNotBeRollback()
    {
        $this->requestMock->expects($this->once())->method('get')->with('id')->will($this->returnValue('id'));
        $this->paymentsStandardMock->expects($this->once())->method('cancel')->with('id')->will($this->throwException(new InvoiceNotBeRollbackException()));
        $result = $this->command->process($this->requestMock);

        $this->assertArrayHasKey('result', $result);
        $this->assertEquals($result['result'], 7);
    }
}
