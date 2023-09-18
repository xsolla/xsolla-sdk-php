<?php

namespace Xsolla\SDK\Webhook\Message;

final class NotificationTypeDictionary
{
    const PAYMENT = 'payment';
    const REFUND = 'refund';
    const PARTIAL_REFUND = 'partial_refund';
//    const UPGRADE_REFUND = 'upgrade_refund';

    const USER_VALIDATION = 'user_validation';
    const USER_SEARCH = 'user_search';
    const USER_BALANCE = 'user_balance_operation';

    const CREATE_SUBSCRIPTION = 'create_subscription';
    const CANCEL_SUBSCRIPTION = 'cancel_subscription';
    const UPDATE_SUBSCRIPTION = 'update_subscription';

    const ORDER_PAID = 'order_paid';
    const ORDER_CANCELED = 'order_canceled';

    const PAYMENT_ACCOUNT_ADD = 'payment_account_add';
    const PAYMENT_ACCOUNT_REMOVE = 'payment_account_remove';

    const PARTNER_SIDE_CATALOG = 'partner_side_catalog';

    const REDEEM_KEY = 'redeem_key';
//    const KEYS_AVAILABILITY = 'keys_availability';

    //other types without any group
    const GET_PIN_CODE = 'get_pincode';
    const AFS_REJECT = 'afs_reject';
}