<?php

namespace Xsolla\SDK\API;

use Guzzle\Common\Collection;
use Guzzle\Common\Event;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Xsolla\SDK\API\PaymentUI\TokenRequest;
use Xsolla\SDK\Exception\API\XsollaAPIException;
use Xsolla\SDK\Version;

/**
 * @method array CreatePaymentUIToken(array $args = array()) Create payment UI token. http://developers.xsolla.com/api.html#payment-ui
 *
 * @method array CreateSubscriptionPlan(array $args = array()) Create a recurrent plan. http://developers.xsolla.com/api.html#create-a-plan
 * @method array UpdateSubscriptionPlan(array $args = array()) Update a recurrent plan. http://developers.xsolla.com/api.html#update-a-plan
 * @method void DeleteSubscriptionPlan(array $args = array()) Delete a recurrent plan. http://developers.xsolla.com/api.html#delete-a-plan
 * @method void DisableSubscriptionPlan(array $args = array()) Disable a recurrent plan. http://developers.xsolla.com/api.html#disable-a-plan
 * @method void EnableSubscriptionPlan(array $args = array()) Enable a recurrent plan. http://developers.xsolla.com/api.html#enable-a-plan
 * @method array ListSubscriptionPlans(array $args = array()) List all recurrent plans. http://developers.xsolla.com/api.html#list-all-plans
 * @method array CreateSubscriptionProduct(array $args = array()) Create a product. http://developers.xsolla.com/api.html#create-a-product
 * @method array UpdateSubscriptionProduct(array $args = array()) Update a product. http://developers.xsolla.com/api.html#update-a-product
 * @method void DeleteSubscriptionProduct(array $args = array()) Delete a product. http://developers.xsolla.com/api.html#delete-a-product
 * @method array ListSubscriptionProducts(array $args = array()) List all recurrent products. http://developers.xsolla.com/api.html#list-all-products
 * @method array UpdateSubscription(array $args = array()) Update a recurrent subscription. It's available to update the status of subscription (active or canceled) and to postpone the date of the next charge for current subscription. http://developers.xsolla.com/api.html#update-subscription
 * @method array ListSubscriptions(array $args = array()) List all recurrent subscriptions. http://developers.xsolla.com/api.html#list-all-subscriptions
 * @method array ListSubscriptionPayments(array $args = array()) List all recurrent payments. http://developers.xsolla.com/api.html#list-all-payments
 * @method array ListUserSubscriptionPayments(array $args = array()) List all recurrent payments by user. http://developers.xsolla.com/api.html#list-all-payments-by-user
 * @method array ListSubscriptionCurrencies(array $args = array()) List all recurrent currencies. http://developers.xsolla.com/api.html#list-all-currencies
 *
 * @method array ListUserAttributes(array $args = array()) Get list of user attributes. http://developers.xsolla.com/api.html#list-all-user-attributes
 * @method array GetUserAttribute(array $args = array()) Show a user attribute. http://developers.xsolla.com/api.html#get-user-attribute
 * @method array CreateUserAttribute(array $args = array()) Create user attribute. http://developers.xsolla.com/api.html#create-user-attribute
 * @method void UpdateUserAttribute(array $args = array()) Update user attribute. http://developers.xsolla.com/api.html#update-user-attribute
 * @method void DeleteUserAttribute(array $args = array()) Delete a user attribute. http://developers.xsolla.com/api.html#delete-user-attribute
 *
 * @method array CreateVirtualItem(array $args = array()) Create a virtual item. http://developers.xsolla.com/api.html#create-an-item
 * @method array GetVirtualItem(array $args = array()) Get a virtual item. http://developers.xsolla.com/api.html#get-an-item
 * @method void UpdateVirtualItem(array $args = array()) Update a virtual item. http://developers.xsolla.com/api.html#update-an-item
 * @method void DeleteVirtualItem(array $args = array()) Delete a virtual item. http://developers.xsolla.com/api.html#delete-an-item
 * @method array ListVirtualItems(array $args = array()) List a virtual items. http://developers.xsolla.com/api.html#list-all-items
 * @method array CreateVirtualItemsGroup(array $args = array()) Create a virtual items group. http://developers.xsolla.com/api.html#create-a-group
 * @method array GetVirtualItemsGroup(array $args = array()) Get a virtual items group. http://developers.xsolla.com/api.html#get-a-group
 * @method void UpdateVirtualItemsGroup(array $args = array()) Update a virtual items group. http://developers.xsolla.com/api.html#update-a-group
 * @method void DeleteVirtualItemsGroup(array $args = array()) Delete a virtual items group. http://developers.xsolla.com/api.html#delete-a-group
 * @method array ListVirtualItemsGroups(array $args = array()) List all virtual items groups. http://developers.xsolla.com/api.html#list-all-groups
 * @method void UpdateVirtualItemOrderInGroup(array $args = array()) Update items order in group. http://developers.xsolla.com/api.html#change-an-items-order
 *
 * @method array GetProjectVirtualCurrencySettings(array $args = array()) Get project virtual currency settings. http://developers.xsolla.com/api.html#list-the-currency-package
 * @method void UpdateProjectVirtualCurrencySettings(array $args = array()) Update project virtual currency settings. http://developers.xsolla.com/api.html#update-the-currency-package
 *
 * @method void CreateWalletUser(array $args = array()) Create a new user. http://developers.xsolla.com/api.html#create-a-new-user
 * @method array GetWalletUser(array $args = array()) Retrieve a user data. http://developers.xsolla.com/api.html#get-a-user
 * @method void UpdateWalletUser(array $args = array()) Update user's information. http://developers.xsolla.com/api.html#update-an-user
 * @method array ListWalletUsers(array $args = array()) List all users. http://developers.xsolla.com/api.html#list-all-users
 * @method array ListWalletUserOperations(array $args = array()) List all operations. http://developers.xsolla.com/api.html#list-all-operations
 * @method array RechargeWalletUserBalance(array $args = array()) Change a balance. http://developers.xsolla.com/api.html#change-a-balance
 * @method array ListWalletUserVirtualItems(array $args = array()) Get user's virtual items. http://developers.xsolla.com/api.html#list-all-virtual-items
 * @method void AddVirtualItemToWalletUser(array $args = array()) Add the virtual items to the user's account. http://developers.xsolla.com/api.html#add-items-to-the-user
 * @method void DeleteVirtualItemFromWalletUser(array $args = array()) Delete the virtual items from the user's account. http://developers.xsolla.com/api.html#delete-items-from-the-user
 *
 * @method array GetCoupon(array $args = array()) Get information about coupon by code. http://developers.xsolla.com/api.html#get-a-coupon
 * @method array RedeemCoupon(array $args = array()) Redeem coupon by code. http://developers.xsolla.com/api.html#redeem-a-coupon
 *
 * @method array CreatePromotion(array $args = array()) Create a new promotion. http://developers.xsolla.com/api.html#create-a-new-promotion
 * @method array GetPromotion(array $args = array()) Get a promotion. http://developers.xsolla.com/api.html#get-the-promotion
 * @method void UpdatePromotion(array $args = array()) Update a promotion. If the promotion is read-only (read_only = true), you are not allowed to change "project_id" parameter. http://developers.xsolla.com/api.html#update-the-promotion
 * @method array ReviewPromotion(array $args = array()) Check the promotion, if it is ready for activation. This method returns the list of errors (if they exist). http://developers.xsolla.com/api.html#review-the-promotion
 * @method void TogglePromotion(array $args = array()) Toggle the promotion. Change the status of promotion from enabled to disabled and vice versa. http://developers.xsolla.com/api.html#toggle-the-promotion
 * @method void DeletePromotion(array $args = array()) Delete a promotion. Only disabled promotion is allowed to delete (enabled = false). http://developers.xsolla.com/api.html#delete-the-promotion
 * @method array ListPromotions(array $args = array()) List all promotions. http://developers.xsolla.com/api.html#list-all-promotions
 * @method array GetPromotionSubject(array $args = array()) Get the subject of the promotion. http://developers.xsolla.com/api.html#get-the-subject
 * @method void SetPromotionSubject(array $args = array()) Set the subject of the promotion. If the promotion is read-only (read_only = true), you are not allowed to update the subject. The subject can take the following values: "purchase", or "items", or "packages". http://developers.xsolla.com/api.html#set-the-subject
 * @method array GetPromotionPaymentSystems(array $args = array()) Get the payment systems of the promotion. If the payment systems list is empty, the promotion will be valid for all payment systems. http://developers.xsolla.com/api.html#get-the-payment-systems
 * @method void SetPromotionPaymentSystems(array $args = array()) Set the payment systems of the promotion. If the payment systems list is empty, the promotion will be applied for all payment systems. If the promotion is read-only (read_only = true), you are not allowed to call this command. http://developers.xsolla.com/api.html#set-the-payment-systems
 * @method array GetPromotionPeriods(array $args = array()) Get the periods of the promotion. http://developers.xsolla.com/api.html#get-the-periods
 * @method void SetPromotionPeriods(array $args = array()) Set the periods of the promotion. If the promotion is read-only (read_only = true), you are not allowed to edit existing periods, add new periods only. http://developers.xsolla.com/api.html#set-the-periods
 * @method array GetPromotionRewards(array $args = array()) Get the rewards of the promotion. http://developers.xsolla.com/api.html#get-the-rewards
 * @method void SetPromotionRewards(array $args = array()) Set the rewards to the promotion. If the promotion is read-only (read_only = true), you are not allowed to update the rewards. http://developers.xsolla.com/api.html#set-the-rewards
 *
 * @method array ListEvents(array $args = array()) List all events from Xsolla Event System. http://developers.xsolla.com/api.html#list-all-events
 *
 * @method array SearchPaymentsRegistry(array $args = array()) Get a transaction list based on specific search parameters. JSON, CSV or XML will be returned in response from the API. http://developers.xsolla.com/api.html#search-all-transactions
 * @method array ListPaymentsRegistry(array $args = array()) Get information about all transactions for specified data range/transfer/report in different data formats. JSON, CSV or XML will be returned in response from the API. http://developers.xsolla.com/api.html#list-all-transactions
 * @method array ListTransfersRegistry(array $args = array()) List all transfers. http://developers.xsolla.com/api.html#list-all-transfers
 * @method array ListReportsRegistry(array $args = array()) Get a list of finance reports for specified data range. http://developers.xsolla.com/api.html#list-all-reports
 * @method void CreateRefundRequest(array $args = array()) Send a refund request. Money will be returned to user. http://developers.xsolla.com/api.html#send-a-refund-request
 *
 * @method array ListSupportTickets(array $args = array()) List all tickets. http://developers.xsolla.com/api.html#list-all-tickets
 * @method array ListSupportTicketComments(array $args = array()) List all comments. http://developers.xsolla.com/api.html#list-all-comments
 *
 * @method array CreateGameDeliveryEntity(array $args = array()) Create game delivery entity http://developers.xsolla.com/api.html#create-game-delivery-entity
 * @method array GetGameDeliveryEntity(array $args = array()) Get a game delivery entity http://developers.xsolla.com/api.html#get-a-game-delivery-entity
 * @method void UpdateGameDeliveryEntity(array $args = array()) Update a game delivery entity http://developers.xsolla.com/api.html#update-a-game-delivery-entity
 * @method array ListGameDeliveryEntities(array $args = array()) List all game delivery entities http://developers.xsolla.com/api.html#list-all-game-delivery-entities
 * @method array ListGameDeliveryDrmPlatforms(array $args = array()) List available DRM platforms http://developers.xsolla.com/api.html#list-available-drm-platforms
 *
 * @method array GetStorefrontVirtualCurrency(array $args = array()) Get virtual currency packages http://developers.xsolla.com/api.html#list-virtual-currency-packages
 * @method array GetStorefrontVirtualGroups(array $args = array()) Get virtual items groups http://developers.xsolla.com/api.html#list-item-groups
 * @method array GetStorefrontVirtualItems(array $args = array()) Get virtual items http://developers.xsolla.com/api.html#list-virtual-items
 * @method array GetStorefrontSubscriptions(array $args = array()) Get available subscriptions http://developers.xsolla.com/api.html#list-subscription-plans
 * @method array GetStorefrontBonus(array $args = array()) Get the information about active promotion http://developers.xsolla.com/api.html#list-promotions
 *
 * @method array CreateProject(array $args = array()) Create a new project http://developers.xsolla.com/api.html#create-a-new-project
 * @method array GetProject(array $args = array()) Get a project http://developers.xsolla.com/api.html#get-a-project
 * @method array UpdateProject(array $args = array()) Update a project http://developers.xsolla.com/api.html#update-a-project
 * @method array ListProjects(array $args = array()) List all projects http://developers.xsolla.com/api.html#list-all-projects
 *
 * @method array ListPaymentAccounts(array $args = array()) List of the saved payment accounts http://developers.xsolla.com/api.html#list-saved-payment-accounts
 * @method array ChargePaymentAccount(array $args = array()) Charge using the saved payment account http://developers.xsolla.com/api.html#charge-using-saved-payment-account
 * @method array DeletePaymentAccount(array $args = array()) Delete the saved payment account http://developers.xsolla.com/api.html#delete-a-saved-payment-account
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
     * @internal
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
                /* @var \Exception $previous */
                $e = new XsollaAPIException(
                    'XsollaClient Exception: '.$previous->getMessage().' Please check troubleshooting section in README.md https://github.com/xsolla/xsolla-sdk-php#troubleshooting',
                    0,
                    $previous
                );
            }
            throw $e;
        };
        /* @var \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher */
        $dispatcher = $client->getEventDispatcher();
        $dispatcher->addListener('request.exception', $exceptionCb);

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
