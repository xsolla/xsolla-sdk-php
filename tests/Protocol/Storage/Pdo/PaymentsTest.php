<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

abstract class PaymentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $dbMock;

    public function setUp()
    {
        $this->dbMock = $this->getMock('Xsolla\SDK\Tests\Protocol\Storage\Pdo\PDOMock');
    }

    public function testCancel()
    {

    }
}