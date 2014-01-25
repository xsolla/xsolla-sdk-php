<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Command;

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
        $this->paymentsStandardMock = $this->getMock(
            '\Xsolla\SDK\Storage\PaymentsStandardInterface',
            array(),
            array(),
            '',
            false
        );
        $this->projectMock = $this->getMock(
            '\Xsolla\SDK\Storage\ProjectInterface',
            array('getProjectId', 'getSecretKey'),
            array(),
            '',
            false
        );
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', array(), array(), '', false);

        $this->projectMock->expects($this->any())->method('getProjectId')->will($this->returnValue(self::PROJECTID));
        $this->projectMock->expects($this->any())->method('getSecretKey')->will($this->returnValue(self::SECRETKEY));

        $this->usersMock = $this->getMock('\Xsolla\SDK\Storage\UsersInterface');

        $this->commandMock = $this->getMock('Xsolla\SDK\Protocol\Command\Command', array('checkSign', 'process', 'getRequiredParams', 'checkRequiredParams'), array(), '', false);
    }

    public function testCheckNoRequiredParams()
    {
        $this->requestMock->expects($this->any())->method('get')->will($this->returnValue(null));
        $this->assertFalse($this->command->checkRequiredParams($this->requestMock));
    }

    public function checkSignTest($request)
    {
        $request[$this->signParamName] = md5($this->getSignString($request) . self::SECRETKEY);
        $this->requestMock->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function ($name) use ($request) {
                    return (isset($request[$name]) ? $request[$name] : null);
                }
            )
        );

        $this->assertTrue($this->command->checkSign($this->requestMock));
    }

    public function testCheckSignFalse()
    {
        $request['md5'] = md5('wrong sign');
        $this->requestMock->expects($this->any())->method('get')->will($this->returnValue('1'));

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
