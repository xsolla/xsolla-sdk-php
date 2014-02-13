<?php
namespace Xsolla\SDK\Storage\Null;

use Xsolla\SDK\Storage\PaymentsStandardInterface;
use Xsolla\SDK\User;

class PaymentsStandard implements PaymentsStandardInterface
{

    public function cancel($invoiceId)
    {
        //do nothing
    }

    public function pay($invoiceId, $amountVirtual, User $user, $dryRun)
    {
        return time();//"unique" id
    }
}
