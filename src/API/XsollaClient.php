<?php

namespace Xsolla\SDK\API;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Xsolla\SDK\API\PaymentUI\TokenRequest;
use Xsolla\SDK\Version;
use Guzzle\Service\Resource\Model;

/**
 * @method Model CreatePaymentUIToken(array $args = array())
 *
 * @method Model CreatePaymentAccount(array $args = array())
 * @method Model DeletePaymentAccount(array $args = array())
 * @method Model ListPaymentAccounts(array $args = array())
 * @method Model MakePayment(array $args = array())
 * @method Model MakeCreditCardPayment(array $args = array())
 *
 * @method Model CreateSubscriptionPlan(array $args = array())
 * @method Model UpdateSubscriptionPlan(array $args = array())
 * @method Model DeleteSubscriptionPlan(array $args = array())
 * @method Model DisableSubscriptionPlan(array $args = array())
 * @method Model EnableSubscriptionPlan(array $args = array())
 * @method Model ListSubscriptionPlans(array $args = array())
 * @method Model CreateSubscriptionProduct(array $args = array())
 * @method Model UpdateSubscriptionProduct(array $args = array())
 * @method Model DeleteSubscriptionProduct(array $args = array())
 * @method Model ListSubscriptionProducts(array $args = array())
 * @method Model UpdateSubscription(array $args = array())
 * @method Model ListSubscriptions(array $args = array())
 * @method Model ListSubscriptionPayments(array $args = array())
 * @method Model ListSubscriptionCurrencies(array $args = array())
 *
 * @method Model GetUserAttribute(array $args = array())
 * @method Model CreateUserAttribute(array $args = array())
 * @method Model UpdateUserAttribute(array $args = array())
 * @method Model DeleteUserAttribute(array $args = array())
 *
 * @method Model CreateVirtualItem(array $args = array())
 * @method Model GetVirtualItem(array $args = array())
 * @method Model UpdateVirtualItem(array $args = array())
 * @method Model DeleteVirtualItem(array $args = array())
 * @method Model ListVirtualItems(array $args = array())
 * @method Model UpdateVirtualItemImage(array $args = array())
 * @method Model DeleteVirtualItemImage(array $args = array())
 * @method Model CreateVirtualItemsGroup(array $args = array())
 * @method Model GetVirtualItemsGroup(array $args = array())
 * @method Model UpdateVirtualItemsGroup(array $args = array())
 * @method Model DeleteVirtualItemsGroup(array $args = array())
 * @method Model ListVirtualItemsGroups(array $args = array())
 * @method Model AddVirtualItemToGroup(array $args = array())
 * @method Model DeleteVirtualItemFromGroup(array $args = array())
 * @method Model UpdateVirtualItemsInGroup(array $args = array())
 * @method Model UpdateVirtualItemOrderInGroup(array $args = array())
 *
 * @method Model GetProjectVirtualCurrencySettings(array $args = array())
 * @method Model UpdateProjectVirtualCurrencySettings(array $args = array())
 *
 * @method Model CreateWalletUser(array $args = array())
 * @method Model GetWalletUser(array $args = array())
 * @method Model UpdateWalletUser(array $args = array())
 * @method Model ListWalletUsers(array $args = array())
 * @method Model ListWalletUserOperations(array $args = array())
 * @method Model RechargeWalletUserBalance(array $args = array())
 * @method Model WithdrawWalletUserBalance(array $args = array())
 * @method Model ListWalletUserVirtualItems(array $args = array())
 *
 * @method Model GetCoupon(array $args = array())
 * @method Model RedeemCoupon(array $args = array())
 */
class XsollaClient extends Client
{
    /**
     * @var int
     */
    protected $merchantId;

    /**
     * @var Client
     */
    protected $guzzleClient;

    public static function factory($config = array())
    {
        $default = array('base_url' => 'https://api.xsolla.com');
        $required = array(
            'merchant_id',
            'api_token'
        );
        $config = Collection::fromConfig($config, $default, $required);
        $client = new static(isset($config['base_url']) ? $config['base_url'] : null, $config);
        $client->setDescription(ServiceDescription::factory(__DIR__.'/../../resources/xsolla-api.php'));
        $client->setDefaultOption('auth', array($config['merchant_id'], $config['api_token'], 'Basic'));
        $client->setDefaultOption('headers', array('Accept' => 'application/json', 'Content-Type' => 'application/json'));
        $client->setDefaultOption('command.params', array('merchant_id' => $config['merchant_id']));
        $client->setUserAgent(Version::getVersion());
        return $client;
    }

    /**
     * @param int $projectId
     * @param string $userId
     * @return string
     */
    public function createCommonPaymentUIToken($projectId, $userId)
    {
        $tokenRequest = new TokenRequest($projectId, $userId);
        return $this->getPaymentUITokenFromRequest($tokenRequest);
    }

    /**
     * @param TokenRequest $tokenRequest
     * @return string
     */
    public function createPaymentUITokenFromRequest(TokenRequest $tokenRequest)
    {
        $parsedResponse = $this->CreatePaymentUIToken(['request' => $tokenRequest->toArray()]);
        return $parsedResponse['token'];
    }
}