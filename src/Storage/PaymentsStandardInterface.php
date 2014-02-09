<?php

namespace Xsolla\SDK\Storage;

use Xsolla\SDK\User;

interface PaymentsStandardInterface extends PaymentsInterface
{
    public function pay($invoiceId, $amountVirtual, User $user, $dryRun);
}
