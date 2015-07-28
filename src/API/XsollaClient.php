<?php

namespace Xsolla\SDK\API;

use Guzzle\Common\Collection;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Xsolla\SDK\API\PaymentUI\TokenRequest;
use Xsolla\SDK\Exception\API\XsollaAPIException;
use Xsolla\SDK\Version;
use Guzzle\Common\Event;

/**
 * @method array CreatePaymentUIToken(array $args = array()) Create payment UI token
 *
 * @method array CreateSubscriptionPlan(array $args = array()) Create a recurrent plan
 * @method array UpdateSubscriptionPlan(array $args = array()) Update a recurrent plan
 * @method void DeleteSubscriptionPlan(array $args = array()) Delete a recurrent plan
 * @method void DisableSubscriptionPlan(array $args = array()) Disable a recurrent plan
 * @method void EnableSubscriptionPlan(array $args = array()) Enable a recurrent plan
 * @method array ListSubscriptionPlans(array $args = array()) List all recurrent plans
 * @method array CreateSubscriptionProduct(array $args = array()) Create a product
 * @method array UpdateSubscriptionProduct(array $args = array()) Update a product
 * @method void DeleteSubscriptionProduct(array $args = array()) Delete a product
 * @method array ListSubscriptionProducts(array $args = array()) List all recurrent products
 * @method array UpdateSubscription(array $args = array()) Update a recurrent subscription. It's available to update the status of subscription (active or canceled) and to postpone the date of the next charge for current subscription.
 * @method array ListSubscriptions(array $args = array()) List all recurrent subscriptions
 * @method array ListSubscriptionPayments(array $args = array()) List all recurrent payments
 * @method array ListSubscriptionCurrencies(array $args = array()) List all recurrent currencies
 *
 * @method array ListUserAttributes(array $args = array()) Get list of user attributes
 * @method array GetUserAttribute(array $args = array()) Show a user attribute
 * @method array CreateUserAttribute(array $args = array()) Create user attribute
 * @method void UpdateUserAttribute(array $args = array()) Update user attribute
 * @method void DeleteUserAttribute(array $args = array()) Delete a user attribute
 *
 * @method array CreateVirtualItem(array $args = array()) Create a virtual item
 * @method array GetVirtualItem(array $args = array()) Get a virtual item
 * @method void UpdateVirtualItem(array $args = array()) Update a virtual item
 * @method void DeleteVirtualItem(array $args = array()) Delete a virtual item
 * @method array ListVirtualItems(array $args = array()) List a virtual items
 * @method string UpdateVirtualItemImage(array $args = array()) Upload an image for virtual item
 * @method void DeleteVirtualItemImage(array $args = array()) Change a virtual item image to default
 * @method array CreateVirtualItemsGroup(array $args = array()) Create a virtual items group
 * @method array GetVirtualItemsGroup(array $args = array()) Get a virtual items group
 * @method void UpdateVirtualItemsGroup(array $args = array()) Update a virtual items group
 * @method void DeleteVirtualItemsGroup(array $args = array()) Delete a virtual items group
 * @method array ListVirtualItemsGroups(array $args = array()) List all virtual items groups
 * @method void UpdateVirtualItemOrderInGroup(array $args = array()) Update items order in group
 *
 * @method array GetProjectVirtualCurrencySettings(array $args = array()) Get project virtual currency settings
 * @method void UpdateProjectVirtualCurrencySettings(array $args = array()) Update project virtual currency settings
 *
 * @method void CreateWalletUser(array $args = array()) Create a new user.
 * @method array GetWalletUser(array $args = array()) Retrieve a user data
 * @method void UpdateWalletUser(array $args = array()) Update user's information
 * @method array ListWalletUsers(array $args = array()) List all users
 * @method array ListWalletUserOperations(array $args = array()) List all operations
 * @method array RechargeWalletUserBalance(array $args = array()) Change a balance
 * @method array ListWalletUserVirtualItems(array $args = array()) Get user's virtual items
 * @method void AddVirtualItemToWalletUser(array $args = array()) Add the virtual items to the user's account
 * @method void DeleteVirtualItemFromWalletUser(array $args = array()) Delete the virtual items from the user's account
 *
 * @method array GetCoupon(array $args = array()) Get information about coupon by code
 * @method array RedeemCoupon(array $args = array()) Redeem coupon by code
 *
 * @method array CreatePromotion(array $args = array()) Create a new promotion
 * @method array GetPromotion(array $args = array()) Get a promotion
 * @method void UpdatePromotion(array $args = array()) Update a promotion. If the promotion is read-only (read_only = true), you are not allowed to change "project_id" parameter.
 * @method array ReviewPromotion(array $args = array()) Check the promotion, if it is ready for activation. This method returns the list of errors (if they exist).
 * @method void TogglePromotion(array $args = array()) Toggle the promotion. Change the status of promotion from enabled to disabled and vice versa.
 * @method void DeletePromotion(array $args = array()) Delete a promotion. Only disabled promotion is allowed to delete (enabled = false).
 * @method array ListPromotions(array $args = array()) List all promotions
 * @method array GetPromotionSubject(array $args = array()) Get the subject of the promotion
 * @method void SetPromotionSubject(array $args = array()) Set the subject of the promotion. If the promotion is read-only (read_only = true), you are not allowed to update the subject. The subject can take the following values: "purchase", or "items", or "packages".
 * @method array GetPromotionPaymentSystems(array $args = array()) Get the payment systems of the promotion. If the payment systems list is empty, the promotion will be valid for all payment systems.
 * @method void SetPromotionPaymentSystems(array $args = array()) Set the payment systems of the promotion. If the payment systems list is empty, the promotion will be applied for all payment systems. If the promotion is read-only (read_only = true), you are not allowed to call this command.
 * @method array GetPromotionPeriods(array $args = array()) Get the periods of the promotion
 * @method void SetPromotionPeriods(array $args = array()) Set the periods of the promotion. If the promotion is read-only (read_only = true), you are not allowed to edit existing periods, add new periods only.
 * @method array GetPromotionRewards(array $args = array()) Get the rewards of the promotion
 * @method void SetPromotionRewards(array $args = array()) Set the rewards to the promotion. If the promotion is read-only (read_only = true), you are not allowed to update the rewards.
 *
 * @method array ListEvents(array $args = array()) List all events from Xsolla Event System
 *
 * @method array ListPayments(array $args = array()) Get information about all transactions for specified data range/transfer/report in different data formats. JSON, CSV or XML will be returned in response from the API.
 * @method array ListTransfers(array $args = array()) List all transfers
 * @method array ListReports(array $args = array()) Get a list of finance reports for specified data range
 * @method void CreateRefundRequest(array $args = array()) Send a refund request. Money will be returned to user
 *
 * @method array ListSupportTickets(array $args = array()) List all tickets
 * @method array ListSupportTicketComments(array $args = array()) List all comments
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

    /**
     * @param  mixed  $value
     * @return string
     */
    public static function jsonEncode($value)
    {
        $flags = 0;
        if (defined('JSON_PRETTY_PRINT')) {
            $flags = JSON_PRETTY_PRINT;
        }

        return json_encode($value, $flags);
    }

    /**
     * @param  array  $config
     * @return static
     */
    public static function factory($config = array())
    {
        $default = array(
            'ssl.certificate_authority' => 'system',
        );
        $required = array(
            'merchant_id',
            'api_key',
        );
        $config = Collection::fromConfig($config, $default, $required);
        $client = new static(isset($config['base_url']) ? $config['base_url'] : null, $config);
        $client->setDescription(ServiceDescription::factory(__DIR__.'/Resources/xsolla-2015-07-23.php'));
        $client->setDefaultOption('auth', array($config['merchant_id'], $config['api_key'], 'Basic'));
        $client->setDefaultOption('headers', array('Accept' => 'application/json', 'Content-Type' => 'application/json'));
        $client->setDefaultOption('command.params', array('merchant_id' => $config['merchant_id']));
        $client->setUserAgent(Version::getVersion());
        $exceptionCb = function (Event $event) {
            $previous = $event['exception'];
            if ($previous instanceof BadResponseException) {
                $e = XsollaAPIException::fromBadResponse($previous);
            } else {
                $e = new XsollaAPIException('XsollaClient Exception: '.$previous->getMessage(), 0, $previous);
            }
            throw $e;
        };
        $client->getEventDispatcher()->addListener('request.exception', $exceptionCb);

        return $client;
    }

    /**
     * @param  int    $projectId
     * @param  string $userId
     * @param  bool   $sandboxMode
     * @return string
     */
    public function createCommonPaymentUIToken($projectId, $userId, $sandboxMode = false)
    {
        $tokenRequest = new TokenRequest($projectId, $userId);
        $tokenRequest->setSandboxMode($sandboxMode);

        return $this->createPaymentUITokenFromRequest($tokenRequest);
    }

    /**
     * @param  TokenRequest $tokenRequest
     * @return string
     */
    public function createPaymentUITokenFromRequest(TokenRequest $tokenRequest)
    {
        $parsedResponse = $this->CreatePaymentUIToken(array('request' => $tokenRequest->toArray()));

        return $parsedResponse['token'];
    }
}
