<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Command;

abstract class CommandTest extends \PHPUnit_Framework_TestCase
{
    protected $signParams = array();

    protected $signParamName = 'md5';

    const SECRETKEY = 'key';
    const PROJECTID = 'project';
    protected $projectMock;
    protected $paymentsCashMock;
    protected $paymentsStandardMock;
    protected $requestMock;
    protected $usersMock;
    /**
     * @var Command
     */
    protected $command;

    protected $commandMock;

    public function setUp()
    {
        $this->paymentsCashMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsCashInterface', [], [], '', false);
        $this->paymentsStandardMock = $this->getMock(
            '\Xsolla\SDK\Storage\PaymentsStandardInterface',
            [],
            [],
            '',
            false
        );
        $this->projectMock = $this->getMock(
            '\Xsolla\SDK\Storage\ProjectInterface',
            ['getProjectId', 'getSecretKey'],
            [],
            '',
            false
        );
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', [], [], '', false);

        $this->projectMock->expects($this->any())->method('getProjectId')->will($this->returnValue(self::PROJECTID));
        $this->projectMock->expects($this->any())->method('getSecretKey')->will($this->returnValue(self::SECRETKEY));

        $this->usersMock = $this->getMock('\Xsolla\SDK\Storage\UsersInterface');

        $this->commandMock = $this->getMock('Xsolla\SDK\Protocol\Command\Command', ['checkSign', 'process', 'getRequiredParams', 'checkRequiredParams'], [], '', false);
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
