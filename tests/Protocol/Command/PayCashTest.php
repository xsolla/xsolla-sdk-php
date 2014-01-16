<?php


namespace Xsolla\SDK\Tests\Protocol\Command;


use Xsolla\SDK\Protocol\Command\PayCash;

class PayCashTest extends \PHPUnit_Framework_TestCase
{
    const SECRETKEY = 'key';
    /**
     * @var PayCash
     */
    protected $payCash;
    protected $projectMock;
    protected $paymentsMock;
    protected $requestMock;

    public function setUp() {
        $this->paymentsMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsInterface');
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface', ['getSecretKey']);
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', [], [], '', false);
        $this->projectMock->expects($this->once())->method('getSecretKey')->will($this->returnValue(self::SECRETKEY));


        $this->payCash = new PayCash($this->projectMock, $this->paymentsMock);
    }

    public function testCheckSign() {
        $request = array(
            'v1' => 'v1',
            'amount' => '123',
            'currency' => 'RUR',
            'id' => '456'
        );

        $request['sign'] = md5($request['v1'].$request['amount'].$request['currency'].$request['id'].self::SECRETKEY);
        $this->requestMock->expects($this->any())->method('get')->will($this->returnCallback(
                function($name) use ($request) {
                    return (isset($request[$name])?$request[$name]:null);
                }
            ));

        $this->assertTrue($this->payCash->checkSign($this->requestMock));
    }

    public function testCheckSignFalse() {
        $request['sign'] = md5('wrong sign');
        $this->requestMock->expects($this->any())->method('get')->will($this->returnValue('1'));

        $this->assertFalse($this->payCash->checkSign($this->requestMock));
    }
}