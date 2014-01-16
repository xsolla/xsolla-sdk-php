<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Cancel;

class CancelTest extends \PHPUnit_Framework_TestCase
{
    const SECRETKEY = 'key';
    /**
     * @var Cancel
     */
    protected $cancel;
    protected $projectMock;
    protected $paymentsMock;
    protected $requestMock;

    public function setUp()
    {
        $this->paymentsMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsInterface');
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface', ['getSecretKey']);
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', [], [], '', false);

        $this->projectMock->expects($this->once())->method('getSecretKey')->will($this->returnValue(self::SECRETKEY));

        $this->cancel = new Cancel($this->projectMock, $this->paymentsMock);
    }

    public function testCheckSign()
    {
        $request = array(
            'command' => 'v1',
            'id' => '456'
        );

        $request['md5'] = md5($request['command'] . $request['id'] . self::SECRETKEY);
        $this->requestMock->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function ($name) use ($request) {
                    return (isset($request[$name]) ? $request[$name] : null);
                }
            )
        );

        $this->assertTrue($this->cancel->checkSign($this->requestMock));
    }

    public function testCheckSignFalse()
    {
        $request['md5'] = md5('wrong sign');
        $this->requestMock->expects($this->any())->method('get')->will($this->returnValue('1'));

        $this->assertFalse($this->cancel->checkSign($this->requestMock));
    }
}
 