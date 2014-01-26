<?php

namespace Xsolla\SDK\Tests\Widget;

use Xsolla\SDK\Widget\CreditCards;
use Xsolla\SDK\Widget\Directpayment;
use Xsolla\SDK\Widget\MobilePayment;
use Xsolla\SDK\Widget\Paystation;
use Xsolla\SDK\Widget\Paydesk;

class WidgetTest extends \PHPUnit_Framework_TestCase
{
    protected $url = 'https://secure.xsolla.com/paystation2/';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $invoiceMock;

    protected $paystation;

    public function setUp()
    {
        $this->userMock = $this->getMock('\Xsolla\SDK\User', array(), array(), '', false);
        $this->userMock->expects($this->any())->method('getEmail')->will($this->returnValue('email'));
        $this->userMock->expects($this->any())->method('getUserIP')->will($this->returnValue('userIP'));
        $this->userMock->expects($this->any())->method('getV1')->will($this->returnValue('v1'));
        $this->userMock->expects($this->any())->method('getPhone')->will($this->returnValue('phone'));

        $this->invoiceMock = $this->getMock('\Xsolla\SDK\Invoice', array(), array(), '', false);

        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface', array(), array(), '', false);
        $this->projectMock->expects($this->any())->method('getProjectId')->will($this->returnValue('projectid'));
        $this->projectMock->expects($this->any())->method('getSecretKey')->will($this->returnValue('key'));
    }

    public function testDirectPaymentWithoutPid()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InvalidArgumentException');

        $this->paystation = new Directpayment($this->projectMock);
        $this->paystation->getLink($this->userMock, $this->invoiceMock);
    }

    public function testMobileWidgetWithoutPid()
    {
        $this->paystation = new MobilePayment($this->projectMock);
        $this->paystation->getLink($this->userMock, $this->invoiceMock);

        $url =  $this->paystation->getLink($this->userMock, $this->invoiceMock);
        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        $this->assertEquals(1738, $query['pid']);
    }

    public function testCreditCardsWithoutPid()
    {
        $this->paystation = new CreditCards($this->projectMock);
        $this->paystation->getLink($this->userMock, $this->invoiceMock);

        $url =  $this->paystation->getLink($this->userMock, $this->invoiceMock);
        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        $this->assertEquals(1380, $query['pid']);
    }

    public function testPaystationWithNullParameters()
    {
        $this->userMock->expects($this->any())->method('getV2')->will($this->returnValue(''));

        $this->paystation = new Paystation($this->projectMock);
        $url =  $this->paystation->getLink($this->userMock, $this->invoiceMock);
        $parts = parse_url($url);
        parse_str($parts['query'], $query);

        $this->assertEquals(false, isset($query['v2']));
    }

    public function testPaystationWithTrueParameters()
    {
        $this->paystation = new Paystation($this->projectMock);
        $url = 'https://secure.xsolla.com/paystation2/?marketplace=paystation&project=projectid&v1=v1&email=email&userip=userIP&phone=phone&sign=908df703503673b6359c273952f3378f';
        $this->assertEquals($url, $this->paystation->getLink($this->userMock, $this->invoiceMock));
    }
}
