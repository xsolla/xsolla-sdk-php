<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

class UserStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $pdoMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userMock;

    /**
     * @var \Xsolla\SDK\Protocol\Storage\Pdo\UserStorage
     */
    protected $userStorage;

    public function setUp()
    {
        $this->pdoMock = $this->getMock('Xsolla\SDK\Tests\Protocol\Storage\Pdo\PDOMock');
        $this->userMock = $this->getMock('Xsolla\SDK\User', array(), array(), '', false);
        $this->userStorage = new \Xsolla\SDK\Protocol\Storage\Pdo\UserStorage($this->pdoMock);
    }

    /**
     * @dataProvider checkProvider
     */
    public function testCheck($expectedValue)
    {
        $selectMock = $this->getMock('PDOStatement');
        $selectMock->expects($this->exactly(3))
            ->method('bindValue')
            ->with($this->anything(), $this->anything());
        $selectMock->expects($this->at(3))
            ->method('execute');
        $selectMock->expects($this->at(4))
            ->method('fetch')
            ->with($this->equalTo(\PDO::FETCH_NUM))
            ->will($this->returnValue($expectedValue));
        $this->pdoMock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo(
                'SELECT 1 FROM xsolla_standard_user WHERE v1 = :v1 AND v2 <=> :v2 AND v3 <=> :v3;'
            ))->will($this->returnValue($selectMock));
        $this->assertEquals($expectedValue, $this->userStorage->isUserExists($this->userMock));
    }

    public function checkProvider()
    {
        return array(
            array(true),
            array(false)
        );
    }

    public function testGetSpec()
    {
        $spec = $this->userStorage->getAdditionalUserFields($this->userMock);
        $this->assertEquals(array(), $spec);
    }
}
 