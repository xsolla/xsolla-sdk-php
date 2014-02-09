<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Command;
use \Symfony\Component\HttpFoundation\ParameterBag;

abstract class CommandTest extends \PHPUnit_Framework_TestCase
{
    protected $signParams = array();

    protected $signParamName = 'md5';

    const SECRETKEY = 'key';
    const PROJECTID = 'project';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $paymentsCashMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $paymentsStandardMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var ParameterBag
     */
    protected $queryBag;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $usersMock;

    /**
     * @var Command
     */
    protected $command;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $commandMock;

    public function setUp()
    {
        $this->paymentsCashMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsCashInterface', array(), array(), '', false);
        $this->paymentsStandardMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsStandardInterface', array(), array(), '', false);

        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', array(), array(), '', false);
        $this->requestMock->query = $this->queryBag = new ParameterBag;

        $this->projectMock = $this->getMock('\Xsolla\SDK\Project', array(), array(), '', false);
        $this->projectMock->expects($this->any())->method('getProjectId')->will($this->returnValue(self::PROJECTID));
        $this->projectMock->expects($this->any())->method('getSecretKey')->will($this->returnValue(self::SECRETKEY));

        $this->usersMock = $this->getMock('\Xsolla\SDK\Storage\UsersInterface');

        $this->commandMock = $this->getMock('Xsolla\SDK\Protocol\Command\Command', array('checkSign', 'process', 'getRequiredParams', 'checkRequiredParams'), array(), '', false);
    }

    public function testCheckNoRequiredParams()
    {
        $this->assertFalse($this->command->checkRequiredParams($this->requestMock));
    }

    public function checkSignTest(array $request)
    {
        $request[$this->signParamName] = md5($this->getSignString($request) . self::SECRETKEY);
        $this->queryBag->replace($request);

        $this->assertTrue($this->command->checkSign($this->requestMock));
    }

    public function testCheckSignFalse()
    {
        $this->queryBag->set('md5', 'incorrect sign');

        $this->assertFalse($this->command->checkSign($this->requestMock));
    }

    public function getSignString($request)
    {
        $string = '';
        foreach ($this->signParams as $param) {
            if (isset($request[$param])) {
                $string .= $request[$param];
            }
        }

        return $string;
    }

    public function testGetResponseInvalidRequest()
    {
        $this->commandMock->expects($this->any())->method('checkRequiredParams')->will($this->returnValue(false));

        $result = $this->commandMock->getResponse($this->requestMock);
        $this->assertArrayHasKey('result', $result);
        $this->assertEquals('4', $result['result']);
    }

    public function testGetResponseInvalidSign()
    {
        $this->commandMock->expects($this->any())->method('checkRequiredParams')->will($this->returnValue(true));
        $this->commandMock->expects($this->any())->method('checkSign')->will($this->returnValue(false));

        $result = $this->commandMock->getResponse($this->requestMock);
        $this->assertArrayHasKey('result', $result);
        $this->assertEquals('3', $result['result']);
    }

    public function testGetResponse()
    {
        $this->commandMock->expects($this->any())->method('checkRequiredParams')->will($this->returnValue(true));
        $this->commandMock->expects($this->any())->method('checkSign')->will($this->returnValue(true));
        $this->commandMock->expects($this->once())->method('process')->will($this->returnValue('result'));

        $this->assertEquals('result', $this->commandMock->getResponse($this->requestMock));
    }

}
