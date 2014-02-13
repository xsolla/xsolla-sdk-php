<?php

namespace Xsolla\SDK\tests\Api;

use Guzzle\Http\Exception\ClientErrorResponseException;
use Xsolla\SDK\Api\Subscriptions;

class SubscriptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subscriptions
     */
    protected $subscriptions;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $clientMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $responseMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $subscriptionMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $invoiceMock;

    public function setUp()
    {
        $this->projectMock = $this->getMock('\Xsolla\SDK\Project', array(), array(), '', false);
        $this->projectMock->expects($this->once())->method('getProjectId')->will($this->returnValue('projectId'));

        $this->userMock = $this->getMock('\Xsolla\SDK\User', array(), array(), '', false);
        $this->userMock->expects($this->any())->method('getV1')->will($this->returnValue('v1'));
        $this->userMock->expects($this->any())->method('getV2')->will($this->returnValue('v2'));
        $this->userMock->expects($this->any())->method('getV3')->will($this->returnValue('v3'));

        $this->clientMock = $this->getMock('\Guzzle\Http\Client', array(), array(), '', false);
        $this->requestMock = $this->getMock('\Guzzle\Http\Message\RequestInterface', array(), array(), '', false);
        $this->responseMock = $this->getMock('\Guzzle\Http\Message\Response', array(), array(), '', false);

        $this->requestMock->expects($this->once())->method('send')->will($this->returnValue($this->responseMock));

        $this->subscriptionMock = $this->getMock('\Xsolla\SDK\Subscription', array(), array(), '', false);
        $this->subscriptionMock->expects($this->any())->method('getId')->will($this->returnValue('id'));
        $this->subscriptionMock->expects($this->any())->method('getProjectId')->will($this->returnValue('projectId'));
        $this->subscriptionMock->expects($this->any())->method('getType')->will($this->returnValue('type'));

        $this->invoiceMock = $this->getMock('\Xsolla\SDK\Invoice', array(), array(), '', false);
        $this->invoiceMock->expects($this->any())->method('getOut')->will($this->returnValue('out'));

        $this->subscriptions = new Subscriptions($this->clientMock, $this->projectMock);
    }

    public function testSearch()
    {
        $this->clientMock->expects($this->once())->method('get')->with(
            '/v1/subscriptions'
        )->will($this->returnValue($this->requestMock));

        $this->responseMock->expects($this->once())
            ->method('json')
            ->will($this->returnValue(
                    array('subscriptions' => array(
                        array(
                            'id' => 'id',
                            'name' => 'name',
                            'type' => 'type',
                            'currency' => 'currency',
                        )
                    ))
                ));

        $subscriptions = $this->subscriptions->search($this->userMock, Subscriptions::TYPE_CARD);
        $this->assertInstanceOf(
            '\Xsolla\SDK\Subscription',
            $subscriptions[0]
        );
    }

    public function testSearchSecurityException()
    {
        $this->setExpectedException('Xsolla\SDK\Exception\SecurityException');
        $exceptionMock = new ClientErrorResponseException();
        $exceptionMock->setResponse($this->responseMock);

        $this->clientMock->expects($this->once())->method('get')->with()->will($this->returnValue($this->requestMock));
        $this->requestMock->expects($this->once())->method('send')->will($this->throwException($exceptionMock));
        $this->responseMock->expects($this->once())
            ->method('json')
            ->will($this->returnValue(array('error' => array('code' => '23', 'message' => 'message'))));

        $this->subscriptions->search($this->userMock, Subscriptions::TYPE_CARD);
    }

    public function testSearchInvalidArgumentException()
    {
        $this->setExpectedException('Xsolla\SDK\Exception\InvalidArgumentException');
        $exceptionMock = new ClientErrorResponseException();
        $exceptionMock->setResponse($this->responseMock);

        $this->clientMock->expects($this->once())->method('get')->with()->will($this->returnValue($this->requestMock));
        $this->requestMock->expects($this->once())->method('send')->will($this->throwException($exceptionMock));
        $this->responseMock->expects($this->once())
            ->method('json')
            ->will($this->returnValue(array('error' => array('code' => '1234', 'message' => 'message'))));

        $this->subscriptions->search($this->userMock, Subscriptions::TYPE_CARD);
    }

    public function testPay()
    {
        $this->clientMock->expects($this->once())->method('post')->with(
            '/v1/subscriptions/type'
        )->will($this->returnValue($this->requestMock));

        $this->responseMock->expects($this->once())
            ->method('json')
            ->will($this->returnValue(array('id' => 'invoiceId')));
        $this->assertEquals('invoiceId', $this->subscriptions->pay($this->subscriptionMock, $this->invoiceMock));
    }

    public function testPayException()
    {
        $this->setExpectedException('Xsolla\SDK\Exception\InvalidArgumentException');
        $exceptionMock = new ClientErrorResponseException();
        $exceptionMock->setResponse($this->responseMock);

        $this->clientMock->expects($this->once())->method('post')->with()->will($this->returnValue($this->requestMock));
        $this->requestMock->expects($this->once())->method('send')->will($this->throwException($exceptionMock));

        $this->responseMock->expects($this->once())
            ->method('json')
            ->will($this->returnValue(array('error' => array('code' => '1234', 'message' => 'message'))));

        $this->subscriptions->pay($this->subscriptionMock, $this->invoiceMock);
    }

    public function testDelete()
    {
        $this->clientMock->expects($this->once())->method('delete')->with(
            '/v1/subscriptions/type'
        )->will($this->returnValue($this->requestMock));

        $this->responseMock->expects($this->once())->method('getStatusCode')->will($this->returnValue(200));
        $this->subscriptions->delete($this->subscriptionMock);
    }

    public function testDeleteException()
    {
        $this->setExpectedException('Xsolla\SDK\Exception\InvalidArgumentException');
        $exceptionMock = new ClientErrorResponseException();
        $exceptionMock->setResponse($this->responseMock);

        $this->clientMock->expects($this->once())->method('delete')->with()->will($this->returnValue($this->requestMock));
        $this->requestMock->expects($this->once())->method('send')->will($this->throwException($exceptionMock));

        $this->responseMock->expects($this->once())
            ->method('json')
            ->will($this->returnValue(array('error' => array('code' => '1234', 'message' => 'message'))));

        $this->subscriptions->delete($this->subscriptionMock);
    }
}
