<?php

namespace Xsolla\SDK\Tests\Protocol;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCartStorageInterface;

class ShoppingCartProtocolFullTest extends ProtocolFullTest
{
    const PAY_V1_SUCCESS = 100;
    const PAY_V1_ANY_EXCEPTION = 103;
    const PAY_ID_UNPROCESSABLE = 104;
    const PAY_SHOP_ID = 555;

    public function setUp()
    {
        parent::setUp();
        $this->paymentStorageMock = $this->getMock('Xsolla\SDK\Protocol\Storage\PaymentShoppingCartStorageInterface', array(), array(), '', false);
        $this->addCancelHandler($this->paymentStorageMock);
        $this->addPayHandler($this->paymentStorageMock);
        $this->protocol = $this->protocolBuilder->getShoppingCartProtocol($this->paymentStorageMock);
    }

    public function payProvider()
    {
        return array(
            array(
                array(
                    'command' => 'pay',
                    'id' => '100',
                    'sign' => 'bc763ff5a8665c7c4c5fa0d8eba75ac8'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>20</result>' .
                '<description>Invalid request format. Not enough arguments. Required: "command", "sign", "id", ' .
                    '"v1", "amount", "currency", "datetime". But received: "command", "id", "sign".</description>' .
                '</response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'id' => '100',
                    'v1' => self::PAY_V1_SUCCESS,
                    'amount' => '100.20',
                    'currency' => 'RUR',
                    'datetime' => '20130325184822',
                    'sign' => '11111ff5a8661171111111d8e1171111'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>20</result><description>Invalid md5 signature</description></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'v1' => self::PAY_V1_SUCCESS,
                    'amount' => '100.20',
                    'currency' => 'RUR',
                    'id' => '555',
                    'datetime' => 'DATETIME',
                    'sign' => 'e15b464029164a011ed8b0eaf14e2fe8'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>20</result>' .
                '<description>Datetime string DATETIME could not be converted to DateTime object from format \'YmdHis\'</description>' .
                '</response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'v1' => self::PAY_V1_ANY_EXCEPTION,
                    'amount' => '100.20',
                    'currency' => 'RUR',
                    'id' => '555',
                    'datetime' => '20130325184822',
                    'sign' => '413ee43a19ff875db28660f501d337f3'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>30</result><description>Any exception</description></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'v1' => self::PAY_ID_UNPROCESSABLE,
                    'amount' => '100.20',
                    'currency' => 'RUR',
                    'id' => '555',
                    'datetime' => '20130325184822',
                    'sign' => '42f0ecd5a69e967fff56ae9f5a9ff021'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>40</result><description>Unprocessable request. unprocessable request</description></response>' . PHP_EOL
            ),
            array(
                array(
                    'command' => 'pay',
                    'v1' => self::PAY_V1_SUCCESS,
                    'amount' => '100.20',
                    'currency' => 'RUR',
                    'id' => '555',
                    'datetime' => '20130325184822',
                    'sign' => 'e15b464029164a011ed8b0eaf14e2fe8'
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>0</result><description/><id_shop>' . self::PAY_SHOP_ID . '</id_shop></response>' . PHP_EOL
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
                '<response><result>20</result>' .
                '<description>No command in request. Available commands are: "pay", "cancel".</description>' .
                '</response>' . PHP_EOL
            )
        );
    }

    public function wrongCommandProvider()
    {
        return array(
            array(
                array(
                    'command' => 'not_exist',
                ),
                '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<response><result>20</result>' .
                '<description>Wrong command: "not_exist". Available commands for protocol ShoppingCart are: "pay", "cancel".</description>' .
                '</response>' . PHP_EOL
            )
        );
    }

    public function addPayHandler(PaymentShoppingCartStorageInterface $paymentStorageMock)
    {
        $paymentStorageMock->expects($this->any())
            ->method('pay')
            ->will($this->returnCallback(array($this, 'payCallback')));
    }

    public function payCallback($invoiceId, $amount, $v1)
    {
        if ($v1 == self::PAY_V1_ANY_EXCEPTION) {
            throw new \Exception('Any exception');
        } elseif ($v1 == self::PAY_ID_UNPROCESSABLE) {
            throw new UnprocessableRequestException('unprocessable request');
        } else {
            return self::PAY_SHOP_ID;
        }
    }
}
