<?php

namespace Xsolla\SDK\Tests\Integration\API;

use Xsolla\SDK\API\XsollaClient;

class ServiceDescriptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XsollaClient
     */
    protected $xsollaClient;

    public function setUp()
    {
        $this->xsollaClient = XsollaClient::factory([
            'merchant_id' => $_SERVER['MERCHANT_ID'],
            'api_key' => $_SERVER['API_KEY']
        ]);
    }

    /**
     * @dataProvider serviceDescriptionProvider
     */
    public function testApiMethod(
        $method,
        $args
    ) {
        $response = call_user_func(array($this->xsollaClient, $method), $args);
        var_export($response);
        //echo PHP_EOL;
        static::assertInternalType('array', $response);
    }

    public function serviceDescriptionProvider()
    {
        $testConfig = array(
            'operations' => array(
                // Payment UI
                'CreatePaymentUIToken' => array(
                    'test' => false,
                ),
                // Direct Payments
                'CreatePaymentAccount' => array(),
                'DeletePaymentAccount' => array(),
                'ListPaymentAccounts' => array(),
                'MakePayment' => array(),
                'MakeCreditCardPayment' => array(),
                // Subscriptions
                'CreateSubscriptionPlan' => array(),
                'UpdateSubscriptionPlan' => array(),
                'DeleteSubscriptionPlan' => array(),
                'DisableSubscriptionPlan' => array(),
                'EnableSubscriptionPlan' => array(),
                'ListSubscriptionPlans' => array(
                    'test' => true,
                    'args' => array('project_id' => (int) $_SERVER['PROJECT_ID'])
                ),
                'CreateSubscriptionProduct' => array(),
                'UpdateSubscriptionProduct' => array(),
                'DeleteSubscriptionProduct' => array(),

                'ListSubscriptionProducts' => array(
                    'test' => true,
                    'args' => array('project_id' => (int) $_SERVER['PROJECT_ID'])
                ),
                'UpdateSubscription' => array(),
                'ListSubscriptions' => array(),
                'ListSubscriptionPayments' => array(),

                'ListSubscriptionCurrencies' => array(
                    'test' => true,
                    'args' => array('project_id' => (int) $_SERVER['PROJECT_ID'])
                ),
                //User attributes
                'ListUserAttributes' => array(
                    'test' => true,
                    'args' => array('project_id' => (int) $_SERVER['PROJECT_ID'])
                ),
                'GetUserAttribute' => array(),
                'CreateUserAttribute' => array(),
                'UpdateUserAttribute' => array(),
                'DeleteUserAttribute' => array(),
                // Virtual Items
                'CreateVirtualItem' => array(),
                'GetVirtualItem' => array(),
                'UpdateVirtualItem' => array(),
                'DeleteVirtualItem' => array(),
                'ListVirtualItems' => array(
                    'test' => true,
                    'args' => array('project_id' => (int) $_SERVER['PROJECT_ID'])
                ),
                'UpdateVirtualItemImage' => array(),
                'DeleteVirtualItemImage' => array(),
                'CreateVirtualItemsGroup' => array(),
                'GetVirtualItemsGroup' => array(),
                'UpdateVirtualItemsGroup' => array(),
                'DeleteVirtualItemsGroup' => array(),
                'ListVirtualItemsGroups' => array(
                    'test' => true,
                    'args' => array('project_id' => (int) $_SERVER['PROJECT_ID'])
                ),
                'AddVirtualItemToGroup' => array(),
                'DeleteVirtualItemFromGroup' => array(),
                'UpdateVirtualItemsInGroup' => array(),
                'UpdateVirtualItemOrderInGroup' => array(),
                // Virtual Currency
                'GetProjectVirtualCurrencySettings' => array(
                    'test' => true,
                    'args' => array('project_id' => (int) $_SERVER['PROJECT_ID'])
                ),
                'UpdateProjectVirtualCurrencySettings' => array(),
                // Wallet
                'CreateWalletUser' => array(),
                'GetWalletUser' => array(),
                'UpdateWalletUser' => array(),
                'ListWalletUsers' => array(
                    'test' => true,
                    'args' => array(
                        'project_id' => (int) $_SERVER['PROJECT_ID'],
                        'limit' => 2,
                        'offset' => 0,
                    )
                ),
                'ListWalletUserOperations' => array(),
                'RechargeWalletUserBalance' => array(),
                'WithdrawWalletUserBalance' => array(),
                'ListWalletUserVirtualItems' => array(),
                // Coupons
                'GetCoupon' => array(
                    'test' => true,
                    'args' => array(
                        'project_id' => (int) $_SERVER['PROJECT_ID'],
                        'code' => '1wpb1igjBig0g',
                    ),
                ),
                'RedeemCoupon' => array(
                    'test' => true,
                    'args' => array(
                        'project_id' => (int) $_SERVER['PROJECT_ID'],
                        'code' => '1wpb1igjBig0g',
                        'user_id' => 1,
                    ),
                ),
                // Promotions
                'CreatePromotion' => array(),
                'GetPromotion' => array(),
                'UpdatePromotion' => array(),
                'ReviewPromotion' => array(),
                'TogglePromotion' => array(),
                'DeletePromotion' => array(),
                'ListPromotions' => array(
                    'test' => true,
                    'args' => array()
                ),
                'GetPromotionSubject' => array(),
                'SetPromotionSubject' => array(),
                'GetPromotionPaymentSystems' => array(),
                'SetPromotionPaymentSystems' => array(),
                'GetPromotionPeriods' => array(),
                'SetPromotionPeriods' => array(),
                'GetPromotionRewards' => array(),
                'SetPromotionRewards' => array(),
                // Events
                'ListEvents' => array(
                    'test' => true,
                    'args' => array()
                ),
                // Reports
                /*
                'ListPayments' => array(
                    'test' => true,
                    'request' => array('format' => 'json')
                ),
                */
                'ListTransfers' => array(
                    'test' => true,
                    'args' => array()
                ),
                'ListReports' => array(
                    'test' => true,
                    'args' => array()
                ),
                'CreateRefundRequest' => array(),
                // Support
                'ListSupportTickets' => array(
                    'test' => true,
                    'args' => array()
                ),
                'ListSupportTicketComments' => array(),//TODO
            ),
        );
        $serviceDescription = require __DIR__ . '/../../../resources/xsolla-api.php';
        $fullConfig = array_merge_recursive($serviceDescription, $testConfig);
        $dataProviderConfig = array();
        foreach ($fullConfig['operations'] as $operation => $operationConfig) {
            if (isset($operationConfig['test']) and true === $operationConfig['test']) {
                $dataProviderConfig[$operation] = array(
                    'method' => $operation,
                    'args' => $operationConfig['args'],
                );
            }
        }
        return [$dataProviderConfig['RedeemCoupon']];
    }
}