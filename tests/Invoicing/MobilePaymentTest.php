<?php

namespace Xsolla\SDK\Tests\Invoicing;

use Guzzle\Service\Client;
use Xsolla\SDK\Invoicing\MobilePayment;

class MobilePaymentTest extends \PHPUnit_Framework_TestCase
{

    protected $requestMock;
    protected $responseMock;
    protected $clientMock;
    protected $projectMock;
    protected $mobilePayment;
    protected $userMock;
    protected $invoiceMock;

    protected $url = 'mobile/payment/index.php';

    protected $queryParamsCalculateWithSum = array(
        'command' => 'calculate',
        'project' => 'projectId',
        'phone' => 'phone',
        'sum' => '10',
    );
    protected $queryParamsCalculateWithOut = array(
        'command' => 'calculate',
        'project' => 'projectId',
        'phone' => 'phone',
        'out' => '100',
    );

    protected $queryParamsForCreateInvoice = array(
        'command' => 'invoice',
        'project' => 'projectId',
        'v1' => 'v1',
        'v2' => 'v2',
        'v3' => 'v3',
        'sum' => '10',
        'out' => '100',
        'phone' => 'phone',
        'userip' => 'userIP',
        'email' => 'email',
    );

    protected $responseWithInvalidRequest =
        '<response>
            <result>4</result>
            <comment>OK</comment>
        </response>';
    protected $responseCalculateWithWrongMd5 =
        '<response>
            <result>3</result>
            <comment>OK</comment>
        </response>';

    protected $responseCreateInvoice =
        '<response>
            <result>0</result>
            <comment>OK</comment>
            <invoice>1</invoice>
        </response>';

    protected $responseWithWrongMd5 =
        '<response>
            <result>3</result>
            <comment>OK</comment>
        </response>';

    protected $responseWithWrongNumber =
        '<response>
            <result>2</result>
            <comment>OK</comment>
        </response>';

    protected $responseCalculateWithInvalidRequest =
        '<response>
            <result>4</result>
            <comment>OK</comment>
        </response>';

    protected $responseWithTechnicalError =
        '<response>
            <result>1</result>
            <comment>OK</comment>
        </response>';

    protected $responseCalculate =
        '<response>
            <sum>10</sum>
            <out>100</out>
            <result>0</result>
            <comment>OK</comment>
        </response>';

    protected $responseCreateInvoiceWithTechnicalError =
        '<response>
            <result>1</result>
            <comment>OK</comment>
        </response>';

    public function setUp()
    {
        $this->requestMock = $this->getMock('\Guzzle\Http\Message\RequestInterface', [], [], '', false);
        $this->responseMock = $this->getMock('\Guzzle\Http\Message\Response', [], [], '', false);
        $this->clientMock = $this->getMock('\Guzzle\Http\Client', [], [], '', false);
        $this->requestMock->expects($this->any())->method('send')->will($this->returnValue($this->responseMock));

        $this->projectMock = $this->getMock(
            '\Xsolla\SDK\Storage\ProjectInterface',
            ['getProjectId', 'getSecretKey'],
            [],
            '',
            false
        );
        $this->projectMock->expects($this->any())->method('getProjectId')->will($this->returnValue('projectId'));
        $this->projectMock->expects($this->any())->method('getSecretKey')->will($this->returnValue('key'));

        $this->userMock = $this->getMock('\Xsolla\SDK\User', [], [], '', false);
        $this->userMock->expects($this->any())->method('getEmail')->will($this->returnValue('email'));
        $this->userMock->expects($this->any())->method('getUserIP')->will($this->returnValue('userIP'));
        $this->userMock->expects($this->any())->method('getV1')->will($this->returnValue('v1'));
        $this->userMock->expects($this->any())->method('getV2')->will($this->returnValue('v2'));
        $this->userMock->expects($this->any())->method('getV3')->will($this->returnValue('v3'));
        $this->userMock->expects($this->any())->method('getPhone')->will($this->returnValue('phone'));

        $this->invoiceMock = $this->getMock('\Xsolla\SDK\Invoice', [], [], '', false);

        $this->mobilePayment = new MobilePayment($this->clientMock, $this->projectMock);
    }

    public function testCalculateWithSum()
    {
        $this->invoiceMock->expects($this->any())->method('getSum')->will($this->returnValue('10'));
        $this->invoiceMock->expects($this->any())->method('getOut')->will($this->returnValue(''));

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCalculate)
        );

        $signString = $this->createSignString($this->queryParamsCalculateWithSum);
        $this->queryParamsCalculateWithSum['md5'] = md5($signString . $this->projectMock->getSecretKey());

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with(
                $this->url,
                array(),
                array('query' => $this->queryParamsCalculateWithSum)
            )
            ->will($this->returnValue($this->requestMock));

        $this->assertInstanceOf(
            '\Xsolla\SDK\Invoice',
            $this->mobilePayment->calculate($this->userMock, $this->invoiceMock)
        );
    }

    public function testCalculateWithOut()
    {
        $this->invoiceMock->expects($this->any())->method('getSum')->will($this->returnValue(''));
        $this->invoiceMock->expects($this->any())->method('getOut')->will($this->returnValue('100'));
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCalculate)
        );

        $signString = $this->createSignString($this->queryParamsCalculateWithOut);
        $this->queryParamsCalculateWithOut['md5'] = md5($signString . $this->projectMock->getSecretKey());

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with(
                $this->url,
                array(),
                array('query' => $this->queryParamsCalculateWithOut)
            )
            ->will($this->returnValue($this->requestMock));

        $this->assertInstanceOf(
            '\Xsolla\SDK\Invoice',
            $this->mobilePayment->calculate($this->userMock, $this->invoiceMock)
        );
    }

    public function testCalculateWithWrongMd5()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\SecurityException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCalculateWithWrongMd5)
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->calculate($this->userMock, $this->invoiceMock);
    }

    public function testCalculateWithTemporaryError()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InternalServerException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseWithTechnicalError)
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->calculate($this->userMock, $this->invoiceMock);
    }

    public function testCalculateWithWrongNumber()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InvalidArgumentException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseWithWrongNumber)
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->calculate($this->userMock, $this->invoiceMock);
    }

    public function testCalculateWithInvalidRequest()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InvalidArgumentException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCalculateWithInvalidRequest)
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->calculate($this->userMock, $this->invoiceMock);
    }

    public function testCalculateWithExceeded()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InvalidArgumentException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(
                '
                                        <response>
                                            <result>7</result>
                                            <comment>OK</comment>
                                        </response>'
            )
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->calculate($this->userMock, $this->invoiceMock);
    }

    public function testCreateInvoice()
    {
        $this->invoiceMock->expects($this->any())->method('getSum')->will($this->returnValue('10'));
        $this->invoiceMock->expects($this->any())->method('getOut')->will($this->returnValue('100'));

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCreateInvoice)
        );

        $signString = $this->createSignString($this->queryParamsForCreateInvoice);
        $this->queryParamsForCreateInvoice['md5'] = md5($signString . $this->projectMock->getSecretKey());

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with(
                $this->url,
                array(),
                array('query' => $this->queryParamsForCreateInvoice)
            )
            ->will($this->returnValue($this->requestMock));

        $this->assertInstanceOf(
            '\Xsolla\SDK\Invoice',
            $this->mobilePayment->createInvoice($this->userMock, $this->invoiceMock)
        );
    }

    protected function createSignString(array $params)
    {
        $signString = '';
        foreach ($params as $value) {
            $signString .= $value;
        }
        return $signString;
    }

    public function testCreateInvoiceWithWrongMd5()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\SecurityException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseWithWrongMd5)
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->createInvoice($this->userMock, $this->invoiceMock);
    }


    public function testCreateInvoiceWithInvalidRequest()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InvalidArgumentException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseWithInvalidRequest)
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->createInvoice($this->userMock, $this->invoiceMock);
    }

    public function testCreateInvoiceWithTechnicalError()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InternalServerException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCreateInvoiceWithTechnicalError)
        );

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->createInvoice($this->userMock, $this->invoiceMock);
    }
}
 