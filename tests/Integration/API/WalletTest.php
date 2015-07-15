<?php

namespace Xsolla\SDK\Tests\Integration\API;

class WalletTest extends AbstractAPITest
{
    public function testCreateWalletUser()
    {
        static::markTestSkipped();
    }

    public function testGetWalletUser()
    {
        static::markTestSkipped();
    }

    public function testUpdateWalletUser()
    {
        static::markTestSkipped();
    }

    public function testListWalletUsers()
    {
        $response = $this->xsollaClient->ListWalletUsers(array(
            'project_id' => $this->projectId,
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }

    public function testListWalletUserOperations()
    {
        $response = $this->xsollaClient->ListWalletUserOperations(array(
            'project_id' => $this->projectId,
            'user_id' => 1,
            'datetime_from' => '2015-01-01T00:00:00 UTC',
            'datetime_to' => '2016-01-01T00:00:00 UTC',
        ));
        static::assertInternalType('array', $response);
    }

    public function testRechargeWalletUserBalance()
    {
        static::markTestSkipped();
    }

    public function testWithdrawWalletUserBalance()
    {
        static::markTestSkipped();
    }

    public function testListWalletUserVirtualItems()
    {
        $response = $this->xsollaClient->ListWalletUserVirtualItems(array(
            'project_id' => $this->projectId,
            'user_id' => 1,
            'limit' => 1,
            'offset' => 0,
        ));
        static::assertInternalType('array', $response);
    }
}