<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\User;

interface PaymentStandardStorageInterface extends PaymentStorageInterface
{
    /**
     * @throws UnprocessableRequestException
     */
    public function pay($invoiceId, $amountVirtual, User $user, \DateTime $date, $dryRun);
}
