<?php


namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\PayStandard;

class PayStandatdTest extends \PHPUnit_Framework_TestCase
{
    const SECRETKEY = 'key';
    /**
     * @var PayStandard
     */
    protected $payStandard;
    protected $projectMock;
    protected $paymentsMock;
    protected $requestMock;

    public function setUp() {
        $this->paymentsMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsInterface');
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface', ['getSecretKey']);
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', [], [], '', false);
        $this->projectMock->expects($this->once())->method('getSecretKey')->will($this->returnValue(self::SECRETKEY));

        $this->payStandard = new PayStandard($this->projectMock, $this->paymentsMock);
    }

    public function testCheckSign() {
        $request = array(
            'command' => 'pay',
            'v1' => 'v1',
            'id' => '456'
        );

        $request['md5'] = md5($request['command'].$request['v1'].$request['id'].self::SECRETKEY);
        $this->requestMock->expects($this->any())->method('get')->will($this->returnCallback(
                function($name) use ($request) {
                    return (isset($request[$name])?$request[$name]:null);
                }
            ));

        $this->assertTrue($this->payStandard->checkSign($this->requestMock));
    }

    public function testCheckSignFalse() {
        $request['md5'] = md5('wrong sign');
        $this->requestMock->expects($this->any())->method('get')->will($this->returnValue('1'));

        $this->assertFalse($this->payStandard->checkSign($this->requestMock));
    }
}