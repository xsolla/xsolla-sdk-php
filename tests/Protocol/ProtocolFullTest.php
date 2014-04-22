<?php

namespace Xsolla\SDK\Tests\Protocol;

use Xsolla\SDK\Exception\InvoiceNotFoundException;
use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Protocol\Storage\PaymentStorageInterface;

abstract class ProtocolFullTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_ID = 12345;
    const PROJECT_KEY = 'key';
    const CLIENT_IP = '127.0.0.1';

    const ZERO = '0';
    const CANCEL_ID_VALID = 100;
    const CANCEL_ID_NOT_FOUND = 101;
    const CANCEL_ID_UNPROCESSABLE = 102;
    const CANCEL_ID_ANY_EXCEPTION = 103;

    const PAY_SHOP_ID = 123100;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $paymentStorageMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $ipCheckerMock;

    /**
     * @var \Xsolla\SDK\Protocol\ProtocolFactory
     */
    protected $protocolBuilder;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var \Symfony\Component\HttpFoundation\Response
     */
    protected $response;

    /**
     * @var \Xsolla\SDK\Protocol\Protocol
     */
    protected $protocol;

    public function setUp()
    {
        $this->projectMock = $this->getMock('\Xsolla\SDK\Project', array(), array(), '', false);
        $this->projectMock->expects($this->any())
            ->method('getProjectId')
            ->will($this->returnValue(self::PROJECT_ID));
        $this->projectMock->expects($this->any())
            ->method('getSecretKey')
            ->will($this->returnValue(self::PROJECT_KEY));

        $this->requestMock = $this->getMock('Symfony\Component\HttpFoundation\Request', array(), array(), '', false);
        $this->ipCheckerMock = $this->getMock('Xsolla\SDK\Validator\IpChecker', array(), array(), '', false);
        $this->requestMock->expects($this->once())
            ->method('getClientIp')
            ->will($this->returnValue(self::CLIENT_IP));
        $this->ipCheckerMock->expects($this->once())
            ->method('checkIp')
            ->with(self::CLIENT_IP);

        $this->protocolBuilder = new \Xsolla\SDK\Protocol\ProtocolFactory($this->projectMock, $this->ipCheckerMock);

        date_default_timezone_set('Europe/Moscow');
    }

    public function protocolTest(array $params, $expectedXml)
    {
        $requestMock = $this->buildRequestMock($params);
        $response = $this->protocol->run($requestMock);
        $actualXml = $response->getContent();
        $message = 'Expected:'.PHP_EOL.$expectedXml.PHP_EOL.'Actual:'.PHP_EOL.$actualXml;
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml, $message);
    }

    /**
     * @dataProvider ipCheckerProvider
     */
    public function testIpCheckerException(array $params, $expectedXml)
    {
        $this->ipCheckerMock->expects($this->once())
            ->method('checkIp')
            ->with(self::CLIENT_IP)
            ->will($this->throwException(new UnprocessableRequestException('IP whitelist doesn\'t contain client IP address')));
        $this->protocolTest($params, $expectedXml);
    }

    /**
     * @dataProvider wrongCommandProvider
     */
    public function testWrongCommand(array $params, $expectedXml)
    {
        $this->protocolTest($params, $expectedXml);
    }

    /**
     * @dataProvider noCommandProvider
     */
    public function testNoCommand(array $params, $expectedXml)
    {
        $this->protocolTest($params, $expectedXml);
    }

    /**
     * @dataProvider cancelProvider
     */
    public function testCancel(array $params, $expectedXml)
    {
        $this->protocolTest($params, $expectedXml);
    }

    /**
     * @dataProvider payProvider
     */
    public function testPay(array $params, $expectedXml)
    {
        $this->protocolTest($params, $expectedXml);
    }

    public function cancelProvider()
    {
        return array(
            array(
                array(
                    'command' => 'cancel'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>4</result>' .
                '<comment>Invalid request format. Missed parameters: md5, id</comment>' .
                '</response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'cancel',
                    'id' => '500'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>4</result>' .
                '<comment>Invalid request format. Missed parameters: md5</comment>' .
                '</response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'cancel',
                    'id' => '500',
                    'md5' => '11111109bbf31111211175a111c3f11'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>3</result><comment>Invalid md5 signature</comment></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'cancel',
                    'id' => self::CANCEL_ID_VALID,
                    'md5' => 'bc763ff5a8665c7c4c5fa0d8eba75ac8'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>0</result><comment/></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'cancel',
                    'id' => self::CANCEL_ID_NOT_FOUND,
                    'md5' => '19715f09bc5b2e9c2e47ce00cb40fc54'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>2</result><comment>Invoice not found.</comment></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'cancel',
                    'id' => self::CANCEL_ID_UNPROCESSABLE,
                    'md5' => '9e652f044a63f2248633eb9a8afecf8e'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>7</result><comment></comment></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'cancel',
                    'id' => self::CANCEL_ID_ANY_EXCEPTION,
                    'md5' => 'a4bbcb6f3e1da6366661181f888ef8be'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>1</result><comment>Any exception</comment></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'cancel',
                    'id' => self::ZERO,
                    'md5' => 'ee46550702331221596b8d4dbb68112e'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>0</result><comment/></response>' . PHP_EOL
            ),
        );
    }

    public function buildCancelRequestMock()
    {
        return $this->buildRequestMock(array(
                'command' => 'cancel',
                'id' => '500',
                'md5' => '680f9109bbf3d008120e275a4ebc3f45'
            ));
    }

    public function addCancelHandler(PaymentStorageInterface $paymentsStorageMock)
    {
        $paymentsStorageMock->expects($this->any())
            ->method('cancel')
            ->will($this->returnCallback(array($this, 'cancelCallback')));
    }

    public function cancelCallback($id)
    {
        switch ($id) {
            case self::CANCEL_ID_NOT_FOUND:
                throw new InvoiceNotFoundException();
            case self::CANCEL_ID_UNPROCESSABLE:
                throw new UnprocessableRequestException();
            case self::CANCEL_ID_ANY_EXCEPTION;
                throw new \Exception('Any exception');
        }
    }

    public function buildRequestMock(Array $params)
    {
        $queryMock = $this->getMock('Symfony\Component\HttpFoundation\ParameterBag');
        $queryMock->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(
                    function ($key) use (&$params) {
                        if (array_key_exists($key, $params)) {
                            return $params[$key];
                        } else {
                            return null;
                        }
                    }
                ));
        $queryMock->expects($this->any())
            ->method('keys')
            ->will($this->returnValue(array_keys($params)));
        $this->requestMock->query = $queryMock;

        return $this->requestMock;
    }
}
