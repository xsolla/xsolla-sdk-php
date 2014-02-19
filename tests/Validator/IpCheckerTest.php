<?php
namespace Xsolla\SDK\Tests\Validator;

use Xsolla\SDK\Validator\IpChecker;

class IpCheckerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IpChecker
     */
    protected $ipChecker;

    public function setUp()
    {
        $this->ipChecker = new IpChecker;
    }

    public function testCheckIp()
    {
        $this->assertNull($this->ipChecker->checkIp('185.30.20.16'));
    }

    public function testCheckIpException()
    {
        $this->setExpectedException(
            'Xsolla\SDK\Exception\SecurityException',
            $this->logicalAnd(
                $this->stringContains('94.103.26.176/29, 159.255.220.240/28, 185.30.20.16/29, 185.30.21.16/29'),
                $this->stringContains('185.30.20.45')
            )
        );
        $this->ipChecker->checkIp('185.30.20.45');
    }
}
