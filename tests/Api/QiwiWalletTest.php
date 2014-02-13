<?php

namespace Xsolla\SDK\tests\Api;

use Xsolla\SDK\Api\QiwiWallet;

class QiwiWalletTest extends MobilePaymentTest
{
    protected $url = 'invoicing/index.php';

    protected $queryParamsCalculateWithSum = array(
        'command' => 'calculate',
        'project' => 'projectId',
        'phone' => 'phone',
        'sum' => '10',
        'ps' => 'qiwi',
    );

    protected $queryParamsCalculateWithOut = array(
        'command' => 'calculate',
        'project' => 'projectId',
        'phone' => 'phone',
        'out' => '100',
        'ps' => 'qiwi',
    );

    protected $responseWithWrongMd5 =
        '<response>
            <result>3</result>
            <comment>OK</comment>
            <successUrl>1</successUrl>
            <failUrl>1</failUrl>
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
            <successUrl>1</successUrl>
            <failUrl>1</failUrl>
        </response>';

    protected $responseWithInvalidRequest =
        '<response>
            <result>4</result>
            <comment>OK</comment>
            <successUrl>1</successUrl>
            <failUrl>1</failUrl>
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
    protected $responseCreateInvoiceWithTechnicalError =
        '<response>
            <result>1</result>
            <comment>OK</comment>
            <successUrl>1</successUrl>
            <failUrl>1</failUrl>
        </response>';

    protected $queryParamsWithoutEmail = array(
        'command' => 'invoice',
        'project' => 'projectId',
        'v1' => 'v1',
        'v2' => 'v2',
        'v3' => 'v3',
        'sum' => '10',
        'out' => '100',
        'phone' => 'phone',
        'userip' => 'userIP',
        'ps' => 'qiwi'
    );
    protected $queryParamsWithoutPs = array(
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

    protected $queryParamsWithPs = array(
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
        'ps' => 'qiwi',
    );
    protected $responseCreateInvoiceWithoutEmail =
        '<response>
            <result>0</result>
            <comment>OK</comment>
            <invoice>1</invoice>
            <successUrl>successUrl</successUrl>
            <failUrl>failUrl</failUrl>
        </response>';
    protected $responseCreateInvoiceWithoutPS =
        '<response>
            <result>4</result>
            <comment>OK</comment>
            <successUrl>successUrl</successUrl>
            <failUrl>failUrl</failUrl>
        </response>';
    protected $responseCreateInvoiceWithPS =
        '<response>
            <result>0</result>
            <comment>OK</comment>
            <invoice>1</invoice>
            <successUrl>successUrl</successUrl>
            <failUrl>failUrl</failUrl>
        </response>';

    public function setUp()
    {
        $this->SetUpMocks();
        $this->queryParamsForCreateInvoice['ps'] = 'qiwi';
        $this->mobilePayment = new QiwiWallet($this->clientMock, $this->projectMock);
    }

    public function testCreateInvoiceWithoutEmail()
    {
        $this->invoiceMock->expects($this->any())->method('getSum')->will($this->returnValue('10'));
        $this->invoiceMock->expects($this->any())->method('getOut')->will($this->returnValue('100'));
        $this->userMock->expects($this->any())->method('getEmail')->will($this->returnValue(''));

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCreateInvoiceWithoutEmail)
        );

        $signString = $this->createSignString($this->queryParamsWithoutEmail);
        $this->queryParamsWithoutEmail['md5'] = md5($signString . self::PROJECT_SECRET_KEY);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with(
                $this->url,
                array(),
                array('query' => $this->queryParamsWithoutEmail)
            )
            ->will($this->returnValue($this->requestMock));

        $this->assertInstanceOf(
            '\Xsolla\SDK\Invoice',
            $this->mobilePayment->createInvoice($this->userMock, $this->invoiceMock)
        );
    }

    public function testCreateInvoiceWithPS()
    {
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCreateInvoiceWithPS)
        );
        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->createInvoice($this->userMock, $this->invoiceMock);
    }

    public function testCreateInvoiceWithoutPS()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InvalidArgumentException');
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue($this->responseCreateInvoiceWithoutPS)
        );
        $signString = $this->createSignString($this->queryParamsWithoutPs);
        $this->queryParamsWithoutPs['md5'] = md5($signString . self::PROJECT_SECRET_KEY);

        $this->clientMock->expects($this->once())
            ->method('get')
            ->will($this->returnValue($this->requestMock));

        $this->mobilePayment->createInvoice($this->userMock, $this->invoiceMock);
    }

}
