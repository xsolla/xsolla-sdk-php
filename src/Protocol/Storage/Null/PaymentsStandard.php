<?php
namespace Xsolla\SDK\Protocol\Storage\Null;

use Xsolla\SDK\Protocol\Storage\PaymentsStandardInterface;
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
