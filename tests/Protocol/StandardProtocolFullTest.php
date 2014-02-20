<?php

namespace Xsolla\SDK\Tests\Protocol;

use Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface;
use Xsolla\SDK\Protocol\Storage\UserStorageInterface;
use Xsolla\SDK\User;

class StandardProtocolFullTest extends ProtocolFullTest {

    const PAY_ID_SUCCESS = 100;
    const PAY_ID_ANY_EXCEPTION = 103;
    const CHECK_V1_SUCCESS = 'demo';
    const CHECK_V1_NOT_EXISTS = 'unknown';
    const CHECK_V1_ANY_EXCEPTION = 'exception';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userStorageMock;

    public function setUp()
    {
        parent::setUp();
        $this->userStorageMock = $this->getMock('Xsolla\SDK\Protocol\Storage\UserStorageInterface', array(), array(), '', false);
        $this->paymentStorageMock = $this->getMock('Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface', array(), array(), '', false);
        $this->addCancelHandler($this->paymentStorageMock);
        $this->addPayHandler($this->paymentStorageMock);
        $this->addCheckHandler($this->userStorageMock);
        $this->protocol = $this->protocolBuilder->getStandardProtocol($this->userStorageMock, $this->paymentStorageMock);
    }

    /**
     * @dataProvider checkProvider
     */
    public function testCheck(array $params, $expectedXml) {
        $this->protocolTest($params, $expectedXml);
    }

    public function checkProvider()
    {
        return array(
            array(
                array(
                    'command' => 'check',
                    'v1' => self::CHECK_V1_ANY_EXCEPTION,
                    'md5' => '22a0964fb976608f25f2d55ee44c01d3'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>1</result><comment>Any exception</comment></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'check',
                    'v1' => self::CHECK_V1_NOT_EXISTS,
                    'md5' => '7c7fce6806ae451419dede822033dd9e'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>7</result><comment/></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'check',
                    'v1' => self::CHECK_V1_SUCCESS,
                    'md5' => 'a3561b90df78828133eb285e36965419'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>0</result><comment/></response>' . PHP_EOL
            ),
        );
    }

    public function noCommandProvider()
    {
        return array(
            array(
                array(
                    'id' => '100',
                    'sign' => 'bc763ff5a8665c7c4c5fa0d8eba75ac8'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>4</result>' .
                '<comment>No command in request. Available commands are: "check", "pay", "cancel".</comment>' .
                '</response>' . PHP_EOL
            )
        );
    }

    public function payProvider()
    {
        return array(
            array(
                array(
                    'command' => 'pay'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>4</result>' .
                '<comment>Invalid request format. Not enough arguments. Required: "command", "md5", "id", "sum", "v1", "date". ' .
                'But received: "command".</comment>' .
                '</response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'md5' => '11111ff5a8661171111111d8e1171111',
                    'id' => self::PAY_ID_SUCCESS,
                    'v1' => 'demo',
                    'sum' => '100.20',
                    'date' => '2014-02-19 20:07:08'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>3</result><comment>Invalid md5 signature</comment></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'md5' => '151783427f854e7c61e54fae5361cacb',
                    'id' => self::PAY_ID_SUCCESS,
                    'v1' => 'demo',
                    'sum' => '100.20',
                    'date' => 'DATE'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>4</result>' .
                '<comment>Datetime string DATE could not be converted to DateTime object from format \'Y-m-d H:i:s\'</comment>' .
                '</response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'md5' => 'b03894e48c0dfa6a9adda90739ca986c',
                    'id' => self::PAY_ID_ANY_EXCEPTION,
                    'v1' => 'demo',
                    'sum' => '100.20',
                    'date' => '2014-02-19 20:07:08'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>1</result><comment>Any exception</comment></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'md5' => '151783427f854e7c61e54fae5361cacb',
                    'id' => self::PAY_ID_SUCCESS,
                    'v1' => 'demo',
                    'sum' => '100.20',
                    'date' => '2014-02-19 20:07:08'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>0</result><comment/><id_shop>' . self::PAY_SHOP_ID . '</id_shop></response>' . PHP_EOL
            ),
        );
    }

    public function addCheckHandler(UserStorageInterface $userStorageMock)
    {
        $userStorageMock->expects($this->any())
            ->method('isUserExists')
            ->will($this->returnCallback(
                   function(User $user) {
                       switch ($user->getV1()) {
                           case self::CHECK_V1_ANY_EXCEPTION:
                               throw new \Exception('Any exception');
                           case self::CHECK_V1_NOT_EXISTS:
                               return false;
                           default:
                               return true;
                       }
                   }
                ));
    }

    public function addPayHandler(PaymentStandardStorageInterface $paymentStorageMock)
    {
        $paymentStorageMock->expects($this->any())
            ->method('pay')
            ->will($this->returnCallback(
                    function(
                        $invoiceId,
                        $amount,
                        User $user,
                        $dryRun
                    ) {
                        if ($invoiceId == self::PAY_ID_ANY_EXCEPTION) {
                            throw new \Exception('Any exception');
                        } else {
                            return self::PAY_SHOP_ID;
                        }
                    }
                ));
    }

} 