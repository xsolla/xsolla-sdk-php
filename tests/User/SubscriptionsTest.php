<?php

namespace Xsolla\SDK\Tests\User;

use Guzzle\Http\Exception\ClientErrorResponseException;
use Xsolla\SDK\Subscription;
use Xsolla\SDK\User\Subscriptions;

class SubscriptionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subscriptions
     */
    protected $subscriptions;
    protected $clientMock;
    protected $projectMock;
    protected $requestMock;
    protected $userMock;
    protected $responseMock;

    protected $subscriptionMock;
    protected $invoiceMock;

    public function setUp()
    {
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface');
        $this->projectMock->expects($this->once())->method('getProjectId')->will($this->returnValue('projectId'));

        $this->userMock = $this->getMock('\Xsolla\SDK\User', [], [], '', false);
        $this->userMock->expects($this->any())->method('getV1')->will($this->returnValue('v1'));
        $this->userMock->expects($this->any())->method('getV2')->will($this->returnValue('v2'));
        $this->userMock->expects($this->any())->method('getV3')->will($this->returnValue('v3'));

        $this->clientMock = $this->getMock('\Guzzle\Http\Client', [], [], '', false);
        $this->requestMock = $this->getMock('\Guzzle\Http\Message\RequestInterface', [], [], '', false);
        $this->responseMock = $this->getMock('\Guzzle\Http\Message\Response', [], [], '', false);

        $this->requestMock->expects($this->once())->method('send')->will($this->returnValue($this->responseMock));

        $this->subscriptionMock = $this->getMock('\Xsolla\SDK\Subscription', [], [], '', false);
        $this->subscriptionMock->expects($this->any())->method('getId')->will($this->returnValue('id'));
        $this->subscriptionMock->expects($this->any())->method('getProjectId')->will($this->returnValue('projectId'));
        $this->subscriptionMock->expects($this->any())->method('getType')->will($this->returnValue('type'));

        $this->invoiceMock = $this->getMock('\Xsolla\SDK\Invoice', [], [], '', false);
        $this->invoiceMock->expects($this->any())->method('getOut')->will($this->returnValue('out'));

        $this->subscriptions = new Subscriptions($this->clientMock, $this->projectMock);
    }

    public function testSearch()
    {
        $this->clientMock->expects($this->once())->method('get')->with(
            '/v1/subscriptions'
        )->will($this->returnValue($this->requestMock));

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(
                json_encode(array('subscriptions' => array(array('id' => 'id', 'name' => 'name', 'type' => 'type', 'currency' => 'currency'))))
            )
        );

        $this->assertInstanceOf(
            '\Xsolla\SDK\Subscription',
            $this->subscriptions->search($this->userMock, Subscriptions::TYPE_CARD)[0]
        );
    }

    public function testSearchSecurityException()
    {
        $this->setExpectedException('Xsolla\SDK\Exception\SecurityException');
        $exceptionMock = new ClientErrorResponseException();
        $exceptionMock->setResponse($this->responseMock);

        $this->clientMock->expects($this->once())->method('get')->with()->will($this->returnValue($this->requestMock));
        $this->requestMock->expects($this->once())->method('send')->will($this->throwException($exceptionMock));
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(json_encode(array('error' => array('code' => '23', 'message' => 'message'))))
        );

        $this->subscriptions->search($this->userMock, Subscriptions::TYPE_CARD)[0];
    }

    public function testSearchInvalidArgumentException()
    {
        $this->setExpectedException('Xsolla\SDK\Exception\InvalidArgumentException');
        $exceptionMock = new ClientErrorResponseException();
        $exceptionMock->setResponse($this->responseMock);

        $this->clientMock->expects($this->once())->method('get')->with()->will($this->returnValue($this->requestMock));
        $this->requestMock->expects($this->once())->method('send')->will($this->throwException($exceptionMock));
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(json_encode(array('error' => array('code' => '1234', 'message' => 'message'))))
        );

        $this->subscriptions->search($this->userMock, Subscriptions::TYPE_CARD)[0];
    }

    public function testPay()
    {
        $this->clientMock->expects($this->once())->method('post')->with(
            '/v1/subscriptions/type'
        )->will($this->returnValue($this->requestMock));

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(
                json_encode(array('id' => 'invoiceId'))
            )
        );
        $this->assertEquals('invoiceId', $this->subscriptions->pay($this->subscriptionMock, $this->invoiceMock));
    }

    public function testPayException()
    {
        $this->setExpectedException('Xsolla\SDK\Exception\InvalidArgumentException');
        $exceptionMock = new ClientErrorResponseException();
        $exceptionMock->setResponse($this->responseMock);

        $this->clientMock->expects($this->once())->method('post')->with()->will($this->returnValue($this->requestMock));
        $this->requestMock->expects($this->once())->method('send')->will($this->throwException($exceptionMock));

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(json_encode(array('error' => array('code' => '1234', 'message' => 'message'))))
        );

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

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(json_encode(array('error' => array('code' => '1234', 'message' => 'message'))))
        );

        $this->subscriptions->delete($this->subscriptionMock);
    }

}
