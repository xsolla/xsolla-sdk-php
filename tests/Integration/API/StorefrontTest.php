<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class StorefrontTest extends AbstractAPITest
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

    public function testGetStorefrontVirtualCurrency()
    {
        $response = $this->xsollaClient->GetStorefrontVirtualCurrency(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetStorefrontVirtualGroups()
    {
        $response = $this->xsollaClient->GetStorefrontVirtualGroups(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetStorefrontVirtualItems()
    {
        $response = $this->xsollaClient->GetStorefrontVirtualItems(
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

    public function testGetStorefrontSubscriptions()
    {
        $response = $this->xsollaClient->GetStorefrontSubscriptions(
            array(
                'project_id' => $this->projectId,
                'user_id' => $this->userId,
                'language' => $this->language,
                'currency' => $this->currency,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetStorefrontBonus()
    {
        $response = $this->xsollaClient->GetStorefrontBonus(
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
