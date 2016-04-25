<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class PaystationTest extends AbstractAPITest
{
    protected $currency;
    protected $language;
    protected $userId;

    public function setUp()
    {
        parent::setUp();
        $this->currency = 'USD';
        $this->language = 'en';
        $this->userId = 'test';
    }

    public function testGetPaystationVirtualCurrency()
    {
        $response = $this->xsollaClient->GetPaystationVirtualCurrency(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetPaystationVirtualGroups()
    {
        $response = $this->xsollaClient->GetPaystationVirtualGroups(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetPaystationVirtualItems()
    {
        $response = $this->xsollaClient->GetPaystationVirtualItems(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
                'group_id' => 7,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetPaystationSubscriptions()
    {
        $response = $this->xsollaClient->GetPaystationSubscriptions(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetPaystationBonus()
    {
        $response = $this->xsollaClient->GetPaystationBonus(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
            )
        );
        static::assertInternalType('array', $response);
    }
}
