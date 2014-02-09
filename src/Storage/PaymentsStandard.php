<?php
namespace Xsolla\SDK\Storage;

use Xsolla\SDK\User;

class PaymentsStandard implements PaymentsStandardInterface
{

    public function cancel($invoiceId)
    {
        // TODO: Implement cancel() method.
    }

    public function pay($invoiceId, $amountVirtual, User $user, $dryRun)
    {
        // TODO: Implement pay() method.
    }
}
