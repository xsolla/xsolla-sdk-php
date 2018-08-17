<?php

namespace Xsolla\SDK\Tests\Integration\API;

/**
 * @group api
 */
class StorefrontTest extends AbstractAPITest
{
    const LANGUAGE = 'en';
    const CURRENCY = 'USD';

    public function testGetStorefrontVirtualCurrency()
    {
        $response = static::$xsollaClient->GetStorefrontVirtualCurrency(
            array(
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetStorefrontVirtualGroups()
    {
        $response = static::$xsollaClient->GetStorefrontVirtualGroups(
            array(
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetStorefrontVirtualItems()
    {
        $response = static::$xsollaClient->GetStorefrontVirtualItems(
            array(
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
                'group_id' => 7,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetStorefrontSubscriptions()
    {
        $response = static::$xsollaClient->GetStorefrontSubscriptions(
            array(
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            )
        );
        static::assertInternalType('array', $response);
    }

    public function testGetStorefrontBonus()
    {
        $response = static::$xsollaClient->GetStorefrontBonus(
            array(
                'project_id' => static::$projectId,
                'user_id' => static::$userId,
                'language' => self::LANGUAGE,
                'currency' => self::CURRENCY,
            )
        );
        static::assertInternalType('array', $response);
    }
}
