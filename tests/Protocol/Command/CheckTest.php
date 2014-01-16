<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Check;

class CheckTest extends \PHPUnit_Framework_TestCase
{
    const SECRETKEY = 'key';
    /**
     * @var Check
     */
    protected $check;
    protected $projectMock;
    protected $usersMock;
    protected $requestMock;

    public function setUp()
    {
        $this->usersMock = $this->getMock('\Xsolla\SDK\Storage\UsersInterface');
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface', ['getSecretKey']);
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', [], [], '', false);

        $this->projectMock->expects($this->once())->method('getSecretKey')->will($this->returnValue(self::SECRETKEY));

        $this->check = new Check($this->projectMock, $this->usersMock);
    }

    public function testCheckSign()
    {
        $request = array(
            'command' => 'check',
            'v1' => 'v1'
        );

        $request['md5'] = md5($request['command'] . $request['v1'] . self::SECRETKEY);
        $this->requestMock->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function ($name) use ($request) {
                    return (isset($request[$name]) ? $request[$name] : null);
                }
            )
        );

        $this->assertTrue($this->check->checkSign($this->requestMock));
    }

    public function testCheckSignFalse()
    {
        $request['md5'] = md5('wrong sign');
        $this->requestMock->expects($this->any())->method('get')->will($this->returnValue('1'));

        $this->assertFalse($this->check->checkSign($this->requestMock));
    }
}
 